<?php
    $dataFile = "data.json";
    
    if(!file_exists($dataFile)) {
        file_put_contents($dataFile, "[]");
    }
    
    $todoItemArray = json_decode(file_get_contents($dataFile), true);

    if (isset($_POST["todoText"])) {
        $newTodoObject = array(
            "text" => $_POST["todoText"],
            "isDone" => false
        );
        $todoItemArray[] = $newTodoObject;
        writeToJson($dataFile, $todoItemArray);
    }

    if (isset($_POST["delete"])) {
        unset($todoItemArray[$_POST["delete"]]);
        $todoItemArray = array_values($todoItemArray);
        writeToJson($dataFile, $todoItemArray);
    }

    if (isset($_POST["setDone"])) {
        $index = $_POST["setDone"];
        $todoItemArray[$index]["isDone"] = !$todoItemArray[$index]["isDone"];
        writeToJson($dataFile, $todoItemArray);
    }

    function writeToJson($dataFile, $todoItemArray) {
        file_put_contents($dataFile, json_encode(
            $todoItemArray, JSON_PRETTY_PRINT));
    }
?>

<!DOCTYPE html>

<html>
    <head>
        <title>
            add-todo 
        </title>
    </head>
    <body
        style="max-width: 600px;
               font-size: 20px;
               background-color: #ededed;
               margin-right: auto;
               margin-left: auto;
               margin-top: 50px;
               margin-bottom: 50px;">
        <form action="main.php" method="POST">
            <span style="display: flex;
                         justify-content: center;
                         padding-left: 25px;
                         padding-right: 25px;">
                <input
                    style="margin-right: 5px; width: 100%; height: 24px;"
                    name="todoText" 
                    type="text" 
                >
                <input
                    style="font-weight: 700; font-size: 16px;"
                    type="submit" 
                    value="Add todo"
                >
            </span>
        </form>
        <ul style="word-break: break-word;
                   padding-right: 40px;
                   margin-top: 32px;
                   list-style-type: none;">
            <form action="main.php" method="POST">
                <?php 
                    foreach($todoItemArray as $key => $todoItem) {
                        echo "<div style=\"margin-top: 12px;";
                        echo "padding-top: 8px;";
                        echo "padding-bottom: 16px;";
                        echo "padding-right: 12px;";
                        echo "padding-left: 12px;";
                        echo $todoItem["isDone"] ?
                            "border: 1px solid green;" :
                            "border: 1px solid black;";
                        echo $todoItem["isDone"] ?
                            "background-color: #dde4dd;" :
                            "background-color: #f4f4f4;";
                        echo "border-radius: 8px;\"";
                        echo ">";
                        echo "<li style=\"margin-top: 16px;".
                             "margin-bottom: 12px;\">"
                             .$todoItem["text"].
                             "</li>";
                        echo "<button ";
                        echo "type=\"submit\"";
                        echo "value=".$key." ";
                        echo "style=\"font-weight: 700; font-size: 16px;";
                        echo "margin-right: 5px;\"";
                        echo "name=\"delete\">Delete</button>";
                        echo "<button 
                                type=\"submit\"
                                value= ".$key."
                                style=\"font-weight: 700; font-size: 16px;\"
                                name=\"setDone\"
                              >";
                        echo $todoItem["isDone"] ?
                            "Undone</button>" :
                            "Done</button>";
                        echo "</div>";
                    }
                ?>
            </form>
        </ul>
    </body>
</html>

