<div class="container">
    <div class="cr-bucket col-lg-7">
        <h1>Register</h1>
        <p>Create a Collectr Account</p>
        <?php if(isset($_GET['err'])): ?>

        <div class="alert alert-danger" role="alert">
            <?php if($_GET['err']=='user'){
                echo "There was an error while registering. Please check your inputs and try again. If the problem
                persists, please contact Collectr tech support";
            } elseif ($_GET['err']=='gender'){
                echo "There was an error adding your gender. Please check your gender input and try again.";
            } else {
                echo "An unknown error occurred. Please contact Collectr Tech Support.";
            }?>
        </div>

        <?php endif; ?>
        <form id="registerForm" method="post" action="userRegister.php" onsubmit="return validateRegister()">
            <input type="hidden" name="submitted">
            <div class="form-group col-lg-12">
                <input class="form-control input-lg" required type="input" id="email" onchange="validateEmail()"
                       name="email" placeholder="Email" data-toggle="tooltip"
                       title="Please enter a valid&#10;email address" value="<?php echo $_SESSION['register-data']['email'];?>">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
            <div class="form-group col-lg-12">
                <input class="form-control input-lg" required type="input" id="userName" onchange="validateUsername()"
                       name="userName" placeholder="Username" data-minlength="5" data-toggle="tooltip"
                       title="Minimum length:&#10;5 characters" value="<?php echo $_SESSION['register-data']['userName'];?>">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
            <div class="form-group col-lg-12">
                <input class="form-control input-lg" required type="password" id="userPassword"
                       onchange="validatePassword()" name="userPassword" placeholder="Password" data-toggle="tooltip"
                       title="Password Requirements:&#10;6-26 characters">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
            <div class="form-group col-lg-12">
                <input class="form-control input-lg" required type="password" id="userPasswordConf"
                       onchange="validatePassword()" name="userPasswordConf" placeholder="Confirm Password">
                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
            </div>
            <div class="form-group col-lg-4">
                <select multiple class="form-control" required id="gender" onchange="validateGender()" name="gender[]"
                        data-toggle="tooltip" title="Select multiple genders&#10;by clicking while holding&#10;down Ctrl of Cmd">
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                    <option value="Agender">Agender</option>
                    <option value="Genderqueer">Genderqueer</option>
                    <option value="DTS">Decline to state</option>
                </select>
            </div>
            <div class="form-group col-lg-5" id="genderInDiv">
                <input class="form-control input-lg" type="input" id="genderIn" placeholder="Gender" data-toggle="tooltip"
                       title="Enter a gender to add to the list">
            </div>
            <div class="form-group col-lg-3" id="addGenderDiv">
                <button class="btn btn-default btn-lg btn-block" type="button" id="addGender"
                        onclick="addGOption()" data-toggle="tooltip" title="Add gender to list">Add Gender</button>
            </div>
            <div class="form-group col-lg-12">
                <select class="form-control input-lg" id="pronouns" name="pronouns" onchange="changePronouns();
                validatePronouns()" data-toggle="tooltip" title="Select gender pronouns&#10;that we will use for you&#10;around the site">
                    <option value="def" selected disabled>Pronouns</option>
                    <option value="masc">He, Him, His</option>
                    <option value="fem">She, Her, Hers</option>
                    <option value="neut">They, Them, Theirs</option>
                    <option value="other">Other (please enter)</option>
                </select>
            </div>
            <div id="customPronouns" name="customPronouns" style="display: none;">
                <div class="form-group col-lg-12">
                <input type="text" class="form-control input-lg" id="subjectP" onchange="validatePronouns()"
                       name="subjectP" placeholder="Subject (e.g. He, She, They)" value="<?php echo $_SESSION['register-data']['subjectP'];?>">
                </div>
                <div class="form-group col-lg-12">
                        <input type="text" class="form-control input-lg" id="objectP" onchange="validatePronouns()"
                       name="objectP" placeholder="Object (e.g. Him, Her, Them)" value="<?php echo $_SESSION['register-data']['objectP'];?>">
                </div>
                <div class="form-group col-lg-12">
                    <input type="text" class="form-control input-lg" id="possDetP" onchange="validatePronouns()"
                       name="possDetP" placeholder="Possessive Determiner (e.g. His, Her, Their)" value="<?php echo $_SESSION['register-data']['possDetP'];?>">
                </div>
                <div class="form-group col-lg-12">
                    <input type="text" class="form-control input-lg" id="possP" onchange="validatePronouns()"
                       name="possP" placeholder="Possessive Pronoun (e.g. His, Hers, Theirs)" value="<?php echo $_SESSION['register-data']['possP'];?>">
                </div>
                <div class="form-group col-lg-12">
                    <input type="text" class="form-control input-lg" id="reflexP" onchange="validatePronouns()"
                       name="reflexP" placeholder="Reflexive (e.g. Himself, Herself, Themself)" value="<?php echo $_SESSION['register-data']['reflexP'];?>">
                </div>
            </div>
            <div class="form-group col-lg-12">
                <input class="btn btn-primary btn-lg btn-block" type="submit" value="Register" data-toggle="tooltip"
                       title="Submit registration">
            </div>
        </form>
    </div>
</div>