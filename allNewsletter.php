<?php
session_start();
require 'conf.inc.php';
require 'functions.php';

if (isAdmin() && isActivated() && isConnected()) {
    include 'header.php';
    ?>
    <body>
    <?php include 'navbar.php'; ?>
    <div class="col-md-5 mx-auto mt-5">
        <form method="POST" action="./functions/sendEmail.php">
            <div>
                <div class="custom-control custom-radio custom-control-inline" onchange="sendToMe('<?php echo $_SESSION['email'] ?>')">
                    <input type="radio" id="customRadioInline1" name="choiceSend" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline1">N'envoyer qu'à moi</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline" onchange="enterEmail()">
                    <input type="radio" id="customRadioInline2" name="choiceSend" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline2">Envoyer à :</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline" onchange="deleteEnterEmail()">
                    <input type="radio" id="customRadioInline3" name="choiceSend" class="custom-control-input">
                    <label class="custom-control-label" for="customRadioInline3">Envoyer à tout le monde</label>
                </div>
                <div id="enterEmailAddress"></div>
            </div>
            <select name="selectNewsletter" class="custom-select mt-3" onchange="changeSelect(this)" required>
                <option selected>Choisir une newsletter ...</option>
                <?php
                $allFiles = glob("newsletters/*");
                for ($i = 0; $i < count($allFiles); $i++) {
                    $newsletters = $allFiles[$i];
                    $support = array('html');
                    $ext = strtolower(pathinfo($newsletters, PATHINFO_EXTENSION));
                    if (in_array($ext, $support)) {
                        echo "<option value='" . $allFiles[$i] . "'>" . $allFiles[$i] . "</option>";
                    } else {
                        continue;
                    }
                }
                ?>
            </select>
            <div class="input-group mb-3 mt-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Objet du mail</span>
                </div>
                <input type="text" class="form-control" name="subject" placeholder="Objet du mail" aria-label="Objet du mail" aria-describedby="basic-addon1" required>
            </div>
            <div class="mt-3 mb-3 ml-3 mr-3">
                <button type="submit" class="btn btn-info"><i class="fas fa-paper-plane"></i>&nbsp;Soumettre</button>
            </div>
        </form>
    </div>
    <script src="scripts/newsletter.js"></script>
<?php
    include 'footer.php';
} else {
    header("Location: login.php");
}
?>
