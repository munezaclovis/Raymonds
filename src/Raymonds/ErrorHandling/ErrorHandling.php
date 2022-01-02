<?php

declare(strict_types=1);

namespace Raymonds\ErrorHandling;

use Throwable;
use Whoops\Run;
use Raymonds\Base\BaseView;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Handler\JsonResponseHandler;

class ErrorHandling
{
    protected Run $run;

    protected PrettyPageHandler | JsonResponseHandler $handler;

    protected const DEFAULT_ERROR_CODES = [401, 403, 404, 500];

    public function __construct()
    {
        $this->run = new Run;
        if (\Whoops\Util\Misc::isAjaxRequest()) {
            $this->handler = new JsonResponseHandler();
            $this->handler->addTraceToOutput(true);
            $this->handler->setJsonApi(true);
        } else {

            $this->handler = new PrettyPageHandler;
        }
    }

    public function handle()
    {
        $dev = true;
        $this->run->register();
        if ($dev) {
            error_reporting(E_ALL);
            ini_set('display_errors', '1');
            $this->handleDevException();
        } else {
            error_reporting(0);
            ini_set('display_errors', '0');
            $this->run->pushHandler(function (Throwable $exception) {
                self::handleProdException($exception);
            });
        }
    }

    public function handleDevException()
    {
        $this->run->pushHandler($this->handler);
    }

    public static function handleProdException(Throwable $exception)
    {
        $code = $exception->getCode();
        if (!in_array($code, self::DEFAULT_ERROR_CODES)) {
            $code = 500;
        }

        http_response_code($code);

        $errorLog = LOG_DIR . "/" . date("Y-m-d") . ".txt";

        $message = "Uncaught exception: " . get_class($exception);
        $message .= "with message " . $exception->getMessage();
        $message .= "\nStack trace: " . $exception->getTraceAsString();
        $message .= "\nThrown in " . $exception->getFile() . " on line " . $exception->getLine();

        ini_set('error_log', $errorLog);
        error_log($message);
        echo "Cannot finish";
        echo (new BaseView)->getTemplate("error/{$code}.html.twig", ["error_message" => $message]);
    }
}
