<?php

declare(strict_types=1);

require "Bot/sendMessage.php";
require "Routes/inspection.php";
require "src/Routes.php";
require "src/User.php";

$user = new User();
$routes = new Routes();
$inspection = new inspection();
$sendMessage = new sendMessage();

$update = json_decode(file_get_contents('php://input'));
$path = parse_url($_SERVER['REQUEST_URI'])['path'];

if (isset($update) && isset($update->message) && isset($update->update_id)) {

    $message = $update->message;
    $chat_id = $message->chat->id;
    $text = $message->text;

    switch ($text) {
        case '/start':
            $sendMessage->startHandler($chat_id);
            break;
        case '/add':
            $sendMessage->addHandler($chat_id);
            break;
        case '/get':
            $sendMessage->getHandler($chat_id);
            break;
        case '/check':
            $sendMessage->checkHandler($chat_id);
            break;
        case '/uncheck':
            $sendMessage->uncheckHandler($chat_id);
            break;
        case '/truncate':
            // Uncomment this line if you have a truncateHandler method
            // $sendMessage->truncateHandler($chat_id);
            break;
        case '/delete':
            $sendMessage->deleteHandler($chat_id);
            break;
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'GET') {

    if ($inspection->isApiCall($path)) {

        if($inspection->isTasksCall($path)) {
    
            if ((int)$inspection->getLastOne($path)) {
        
                echo json_encode($routes->returnIdTask((int)$inspection->getLastOne($path) - 1));
                return;

            } else {
        
                echo json_encode($routes->returnTasks());
                return;
            }
    
        } else {
            echo "Enter the tasks";
            return;
        }
    } else {
        echo "Enter the api request";
        return;
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($inspection->isApiCall($path)) {

        if($inspection->isTasksCall($path)) {
    
            if($inspection->getLastOne($path)) {

                $routes->saveTask($inspection->getLastOne($path));
                echo "Task added successfully";
                return;

            } else {

                echo "Enter the tasks or text you want to save";
                return;
            }

        } else {
            echo "Enter the tasks";
            return;
        }
    } else {
        echo "Enter the api request";
        return;
    }


} elseif ($_SERVER['REQUEST_METHOD'] == 'PATCH') {

    if ($inspection->isApiCall($path)) {

        if($inspection->isTasksCall($path)) {

            if($inspection->getBeforeTheLast($path) == 'check') {

                if($inspection->getLastOne($path)) {

                    $routes->checkedTaskId((int)$inspection->getLastOne($path) - 1, 1);
                    echo "Task checked successfully";

                } else {
                    echo "Enter the id";
                }

            } elseif($inspection->getBeforeTheLast($path) == 'uncheck') {

                if($inspection->getLastOne($path)) {

                    $routes->checkedTaskId((int)$inspection->getLastOne($path) - 1, 0);
                    echo "Task unchecked successfully";

                } else {
                    echo "Enter the id";
                    return;
                }
            } else {
                echo "Enter the check or uncheck";
                return;
            }
        } else {
            echo "Enter the tasks";
            return;
        }
    } else {
        echo "Enter the api request";
        return;
    }

} elseif ($_SERVER['REQUEST_METHOD'] == 'DELETE') {

    if ($inspection->isApiCall($path)) {

        if($inspection->isTasksCall($path)) {

            if($inspection->getBeforeTheLast($path)) {

                if($inspection->getLastOne($path)) {

                    $routes->deleteTasksId((int)$inspection->getLastOne($path) - 1);
                    echo "Task deleted successfully";
                    return;

                } else {

                    echo "Enter the id";
                    return;
                }
            } else {
                echo "Enter the delete query";
                return;
            }


        } else {
            echo "Enter the tasks";
            return;
        }
    } else {
        echo "Enter the api request";
        return;
    }

}