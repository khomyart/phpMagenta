<?php

    class feedback
    {
        private $query = 'INSERT INTO `feedback`(`email`, `phone`, `name`, `question`, `time`) 
                                    VALUES (:email, :phone, :name, :question, :time);';
        private $params;
        private $errorsList;

        public function __construct($mail, $phone_number, $name, $question)
        {
            $this->params['email'] = $mail;
            $this->params['phone'] = $phone_number;
            $this->params['name'] = $name;
            $this->params['question'] = $question;
            $this->params['time'] = date('Y-m-d H:i:s');
        }

        public function fieldsDataValidator($phone_number, $name, $question)
        {
            if (strlen($phone_number) == 0
                || strlen($name) == 0
                || strlen($question) == 0) {
                $this->errorsList = 'Заповніть усі поля відмічені *';
            }
            return $this->errorsList;
        }

        public function write()
        {
            global $pdo;

            $statement = $pdo->prepare($this->query);
            $statement->execute($this->params);

            return $statement;
        }

    }

    $email = $_REQUEST['email'];
    $phone = $_REQUEST['phone'];
    $name = $_REQUEST['name'];
    $question = $_REQUEST['question'];

    if ($_REQUEST['submitFeedback']) {
        $feedback = new feedback($email, $phone, $name, $question);
        $inputError = $feedback->fieldsDataValidator($phone, $name, $question);

        if (!$inputError) {
            $feedback->write();
            header ('Location: ../index.php?feedback=success');
        } else {
            echo $inputError.'<br/>';
        }
    }

?>

<style>
    .feedback-form {
        display: flex;
        flex-direction: row;
        margin-top: 20px;
        background-color: rgba(0, 0, 0, 0.18);
        width: 600px;
        justify-content: center;
        padding: 1rem;
        border-radius: 10px;
    }

    .feedback-right-part {
        display: flex;
        flex-direction: column;
        width: 45%;
        height: 100%;
        justify-content: start;
    }

    .feedback-form-space-between {
        width: 20px;
    }

    .feedback-form-field {
        display: flex;
        flex-direction: column;
        justify-content: start;
        height: 23.6%;
    }

    .feedback-form-field input {
        outline: none;
        border-radius: 5px;
        border: 1px solid rgba(128, 128, 128, 0.51);
        padding: 0.5rem;
        margin: 5px 0px ;
    }

    .feedback-form-field textarea {
        outline: none;
        border-radius: 5px;
        border: 1px solid rgba(128, 128, 128, 0.51);
        padding: 0.5rem;
        margin: 5px 0px ;
        box-sizing: content-box;
        height: 61%;
        resize: none;
    }

    .feedback-form-field input:focus{
        box-shadow:0 0 4px 2px rgba(127, 0, 127, 0.63);
    }

    .feedback-form-field textarea:focus{
        box-shadow:0 0 4px 2px rgba(127, 0, 127, 0.63);
    }

    .mail {
        //width: 100%;
    }

    .phone-numeral {
        //width: 100%;
    }

    .name {
    //width: 100%;
    }

    .question {
        width: 100%;
        height: 92%;
    }

    .invalid-field {
        box-shadow:0 0 4px 2px rgba(230, 11, 17, 0.9);
    }

    .feedback-form-question-field-and-button-holder {
        display: flex;
        flex-direction: column;
        width: 45%;
        box-sizing: content-box;
    }

    .button {
        width: 100%;
        height: 86%;
        border-radius: 5px;
        background: white;
        outline: none;
        border: none;
        transition: 0.2s all ease-in-out;
    }

    .button:hover {
        box-shadow:0 0 4px 2px rgba(127, 0, 127, 0.63);
        cursor: pointer;
    }

</style>

<form action="" method="get">
    <div class="feedback-form">
        <div class="feedback-right-part">
            <div class="feedback-form-field mail">
                <label for="email">Адреса електронної пошти:</label>
                <input type="email" pattern="[^@]+@[^@]+\.[a-zA-Z]{2,6}" title='Зразок пошти: example@gmail.com"'
                       class="feedback-form-mail-data-field" id="email" name="email"
                       value="<?= !$errorsList ? $_REQUEST['email'] : '' ?>">
            </div>
            <div class="feedback-form-field phone-numeral">
                <label for="phone-number">* Номер мобільного:</label>
                <input type="tel" pattern="(\+?\d[- .]*){7,13}" title='Зразок номеру: "+380506214211"'
                       class="feedback-form-phone-number-data-field
                       <?= !$_REQUEST['phone'] ? 'invalid-field' : ''?>" id="phone-number" name="phone"
                       value="<?= !$errorsList ? $_REQUEST['phone'] : '' ?>">
            </div>
            <div class="feedback-form-field name">
                <label for="name">* Ім'я:</label>
                <input type="text" class="feedback-form-name-data-field
                <?= !$_REQUEST['name'] ? 'invalid-field' : ''?>" id="name" name="name"
                       value="<?= !$errorsList ? $_REQUEST['name'] : '' ?>">
            </div>
        </div>
        <div class="feedback-form-space-between">
        </div>
        <div class="feedback-form-question-field-and-button-holder">
            <div class="feedback-form-field question">
                <label for="question">* Питання:</label>
                <textarea type="text" class="feedback-form-textarea-data-field
                <?= !$_REQUEST['question'] ? 'invalid-field' : ''?>" id="question" name="question"
                ><?= !$errorsList['question'] ? $_REQUEST['question'] : '' ?></textarea>
            </div>
            <div class="feedback-form-field ">
                <button class="button" type="submit" name="submitFeedback" value="send">
                    Надіслати
                </button>
            </div>
        </div>
    </div>
</form>
