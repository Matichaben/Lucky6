<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\Modal $modal */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var \frontend\models\PhoneForm $model */
use yii\bootstrap5\Html;
use yii\bootstrap5\ActiveForm;

$this->title = 'Lucky Sita';
?>
<div style="color: white" class="site-index">
    <div class="containery">
        <marquee>Play play play and be a lucky winner!!!</marquee>
        <h1>LUCKYSITA</h1>
        <p class="choose">Choose a number:</p>
        <div class="row cubes">
            <?php
            $luckyNumber = mt_rand(1, 6); // Generate a random lucky number (1-6)
            $colors = ['#ff4081', '#3f51b5', '#4caf50', '#f44336', '#9c27b0', '#ff9800'];
            $messages = [
                'Congratulations! You won!',
                'Better luck next time!',
                'You missed the chance!',
                'Unlucky this time!',
                'You nearly hit it!',
                'Almost there, try again!'
            ];
            shuffle($messages); // Randomize the order of messages
            for ($i = 1; $i <= 6; $i++) {
                $color = $colors[$i - 1];
                $message = $messages[$i - 1];
                echo '<div class="col-xs-4 col-sm-4 col-md-4">
                    <div class="number" onclick="selectNumber(' . $i . ')">
                            <div class="cube">
                                <div class="cube-front" style="background-color: ' . $color . '; cursor: context-menu; color: white; padding-top: 30px;">' . $i . '</div>
                                <div class="cube-back" style="background-color: ' . $color . ';"></div>
                                <div class="cube-top" style="background-color: ' . $color . ';"></div>
                                <div class="cube-bottom" style="background-color: ' . $color . '; cursor: context-menu; color: white; padding-top: 30px;">' . $i . '</div>
                                <div class="cube-left" style="background-color: ' . $color . '; cursor: context-menu; color: white; padding-top: 30px;">' . $i . '</div>
                                <div class="cube-right" style="background-color: ' . $color . ';"></div>
                            </div>
                            
                        </div>
                </div>';
            }
            ?>
        </div>
        <div class="decorations">
            <div class="decoration"></div>
            <div class="decoration"></div>
            <div class="decoration"></div>
            <div class="decoration"></div>
        </div>
        <div id="result"></div>
    </div>
    <div>
        <div id="myModal" class="modal">
            <div class="modal-content">
                <?php $form = ActiveForm::begin(['id' => 'number-form']); ?>
                <div class="my-1 mx-0" style="color: white;">
                    Please enter your number to pay and play..
                </div>

                <?= $form->field($model, 'phonenumber')->textInput(['type' => 'number', 'autofocus' => true, 'placeholder' => "0712345678 or 254712345678"]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary', 'name' => 'STK-button']) ?>
                </div>

                <p>After submit, check your phone for a popup and proceed to pay!!</p>

                <?php ActiveForm::end(); ?>
            </div>

        </div>
    </div>
    <script>
        function selectNumber(number) {
            var numbers = document.getElementsByClassName('number');
            for (var i = 0; i < numbers.length; i++) {
                numbers[i].classList.remove('selected');
            }
            document.getElementById('result').innerHTML = '';
            var selectedNumber = document.getElementsByClassName('number')[number - 1];
            selectedNumber.classList.add('selected');
            checkLuckyNumber(number);
        }

        function checkLuckyNumber(number) {
            var luckyNumber = <?php echo $luckyNumber; ?>;
            var messages = <?php echo json_encode($messages); ?>; // Get the shuffled messages array
            var message = messages[number - 1]; // Get the corresponding message for the selected number
            document.getElementById('result').innerHTML = message;
        }

        var modal = document.getElementById("myModal");

        function closeModal() {
            modal.style.display = "none";
        }

        // $(window).load(function () {

        //     // var url = 'http://luckysita.test/site/index';
        //     $('#modal').modal('show').find('#modalContent')
        //         .load($(this).attr('value'));
        // });


        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks on <span> (x), close the modal
        // span.onclick = function () {
        //     modal.style.display = "none";
        // }

        // When the user clicks anywhere outside of the modal, close it
        // window.onclick = function (event) {
        //     if (event.target == modal) {
        //         modal.style.display = "none";
        //     }
        // }
    </script>
    <?php
    function closeModal()
    {
        echo '<script type="text/javascript">',
            'closeModal();',
            '</script>'
        ;
    }
    ?>
</div>