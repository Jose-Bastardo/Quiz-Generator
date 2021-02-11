<?php

Class question {

    public $question;
    public $canswer;
    public $answer2;
    public $answer3;
    public $answer4;

    function __construct($question, $canswer, $answer2, $answer3, $answer4){
        $this->question = $question;
        $this->canswer = $canswer;
        $this->answer2 = $answer2;
        $this->answer3 = $answer3;
        $this->answer4 = $answer4;
    }

    function getquestion(){
        return $this->question;
    }

    function getcanswer(){
        return $this->canswer;
    }

    function getanswer2(){
        return $this->answer2;
    }

    function getanswer3(){
        return $this->answer3;
    }

    function getanswer4(){
        return $this->answer4;
    }

}

$Questionarray = array(
    new question("What color is the sky?", "Blue", "Red", "Green", "Yellow"),
    new question("What state do we live in?", "Florida", "Colorado", "Nevada", "New York"),
    new question("How many wheels does a bicycle have?", "2", "4", "3", "1"),
    new question("What is 2x2?", "4", "6", "7", "10"),
    new question("What year is it?", "2020", "2021", "2019", "2021"),
    new question("What function do you use to send messages to the console", "console.log()", "log()", "log.console()", "console()"),
    new question("How many tentacles does an octopus have?", "8", "10", "6", "4"),
    new question("What is √4?", "2", "4", "1", "3"),
    new question("What is the molecular structure of water", "H2O", "O2", "NaCl", "SO2"),
    new question("How many holes are in a standard bowling bowl?", "3", "2", "1", "5")
    )
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Quiz Generator</title>
    <link rel="stylesheet" href="style.css" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>
<body>
<main>
    <header>
        <h1>Quiz Generator</h1>
    </header>
    <hr />
    <section id="scrollquiz">
        <?php
            shuffle($Questionarray);

            for($i=1; $i<=count($Questionarray); $i++){
                $options = array($Questionarray[$i-1]->getcanswer(),
                    $Questionarray[$i-1]->getanswer2(),
                    $Questionarray[$i-1]->getanswer3(),
                    $Questionarray[$i-1]->getanswer4()
                    );

                shuffle($options);

                $formid = "form".$i;
                echo"
                    <div id='question".$i."'>
                        <form id='".$formid."' name='form".$i."' action='' method='POST'>
                            <table>
                                <tr>
                                    <th colspan='2'><p id='question".$i."text' >".$i.". ".$Questionarray[$i-1]->getquestion()."</p></th>
                                </tr>
                                <tr>
                                    <td class='radio' id='option1radio'><input type='radio' name='options' id='option1' value='option1' /></td>
                                    <td class='label' id='option1label'><label id='label1' for='option1'>".$options[0]."</label></td>
                                </tr>
                                    <td class='radio' id='option2radio'><input type='radio' name='options' id='option2' value='option2'/></td>
                                    <td class='label' id='option2label'><label id='label2' for='option2'>".$options[1]."</label></td>
                                </tr>
                                    <td class='radio' id='option3radio'><input type='radio' name='options' id='option3' value='option3'/></td>
                                    <td class='label' id='option3label'><label id='label3' for='option3'>".$options[2]."</label></td>
                                </tr>
                                    <td class='radio' id='option4radio'><input type='radio' name='options' id='option4' value='option4'/></td>
                                    <td class='label' id='option4label'><label id='label4' for='option4'>".$options[3]."</label></td>
                                </tr>
                                    <td class='submitcell' colspan='2'><button id='submit' type='submit' value='submit' class='btn btn-primary'>Submit</button></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <script>

                       for(let i = 1; i<=4; i++){
                            let label = document.querySelector('#".$formid." #label' + i.toString());
                            if(label.innerHTML === '".$Questionarray[$i-1]->getcanswer()."'){
                                let input = document.querySelector('#".$formid." #option' + i.toString());
                                input.value = 'optionc';
                                let labeltd = document.querySelector('#".$formid." #option' + i.toString() + 'label');
                                labeltd.id ='optionclabel';
                                break;
                            }
                        }
                            
                        $( '#".$formid."' ).on( 'submit', function(e) {
                            
                            let dataString = $(this).serialize();

                                $.ajax({
                                    type: 'POST',
                                    url: 'checkanswer.php',
                                    data: dataString,
                                    success: function (data) {
                                        let string = data.split(',');
                                        if(string[0] === '1'){
                                            let answer = document.querySelector('#".$formid." #optionclabel');
                                            answer.style.backgroundColor = 'lightgreen';
                                            let radio = document.querySelector('#".$formid." input[value=optionc]');
                                            let p = document.createElement('p');
                                            p.innerHTML = 'Correct';
                                            radio.after(p);
                                            
                                            let submitbutton = document.querySelector('#".$formid." #submit');
                                            submitbutton.remove();
                                            
                                            let radiolist = document.querySelectorAll('#".$formid." input');
                                        
                                            radiolist.forEach(function(x){
                                                x.remove();
                                            })
                                         }
                                         else if(string[0] === '0'){
                                            
                                            let youroptionlabel = document.querySelector('#".$formid." #' + string[1] + 'label');
                                            youroptionlabel.style.backgroundColor = 'red';
                                            let youroption = document.querySelector('#".$formid." #' + string[1]);
                                            let p1 = document.createElement('p');
                                            p1.innerHTML = 'Your Answer';
                                            youroption.after(p1);
                                            
                                            let correctoptionlabel = document.querySelector('#".$formid." #optionclabel');
                                            correctoptionlabel.style.backgroundColor = 'lightgreen';
                                            let correctoption = document.querySelector('#".$formid." input[value=optionc]');
                                            let p2 = document.createElement('p');
                                            p2.innerHTML = 'Correct Answer';
                                            correctoption.after(p2);
                                            
                                            let submitbutton = document.querySelector('#".$formid." #submit');
                                            submitbutton.remove();
                                            
                                            let radiolist = document.querySelectorAll('#".$formid." input');
                                            radiolist.forEach(function(x){
                                                x.remove();
                                            })
                                         }
                                         else{
                                         alert('Please enter answer for question ".$i."');
                                         
                                         }
                                         
                                        
                                    }
                                        
                                })
                    
                            e.preventDefault();
                        });
                </script>
                ";
            }
        ?>
    </section>
    <footer>
        <hr />
        <div>
            <input type="button" name="previous" id="previous" value="<" onclick="previousquestion()"/>
            <input type="button" name="next" id="next" value=">" onclick="nextquestion()"/>
        </div>
    </footer>
</main>

<script>

    let currentquestion = 1;

    function previousquestion(){
        if(currentquestion > 1){
            currentquestion--;
            let elmnt = document.getElementById("question" + currentquestion.toString());
            elmnt.scrollIntoView();
        }
    }

    function nextquestion(){
        if(currentquestion < <?php echo count($Questionarray)?>){
            currentquestion++;
            let elmnt = document.getElementById("question" + currentquestion.toString());
            elmnt.scrollIntoView();
        }
    }
</script>
</body>
</html>