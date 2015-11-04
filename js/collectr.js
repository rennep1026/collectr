$(function () {
    $('[data-toggle="tooltip"]').tooltip({
        'placement' : function(tt, trigger){
            if($(window).width()>=1200){
                return "left";
            }
            else{
                return "bottom";
            }
        }
    })
})

function validateLogin(){
    return false;
}

/**
 * Checks that all fields are valid.
 *
 * @returns {boolean|*} True when all fields are valid
 */
function validateRegister(){
    validEmail = validateEmail();
    validUsername = validateUsername();
    validPassword = validatePassword();
    validGender = validateGender();
    validPronouns = validatePronouns();
    return (validEmail && validUsername && validPassword && validGender && validPronouns);
}

/**
 * Adds current input to Gender options
 */
function addGOption(){
    g = document.getElementById("gender");
    gIn = document.getElementById("genderIn");
    newG = document.createElement("option");
    newG.text = gIn.value;
    newG.value = gIn.value;
    g.options.add(newG, 0);

}

/**
 * Brings up or removes custom gender fields when "other" pronouns selected.
 */
function changePronouns(){
    p = document.getElementById("pronouns");

    subjP = document.getElementById('subjectP');
    objP = document.getElementById('objectP');
    possDetP = document.getElementById('possDetP');
    possP = document.getElementById('possP');
    reflexP = document.getElementById('reflexP');

    selected = p[p.selectedIndex];
    custom = document.getElementById("customPronouns");
    if (selected.value == 'other'){
        custom.style.display = 'block';
    }
    else{
        custom.style.display = 'none';
    }
    if(selected.value=='masc'){
        subjP.value = "he";
        objP.value = "him";
        possDetP.value = "his";
        possP.value = "his";
        reflexP.value = "himself";
    }
    if(selected.value=='fem'){
        subjP.value = "she";
        objP.value = "her";
        possDetP.value = "her";
        possP.value = "hers";
        reflexP.value = "herself";
    }
    if(selected.value=='neut'){
        subjP.value = "they";
        objP.value = "them";
        possDetP.value = "their";
        possP.value = "theirs";
        reflexP.value = "themself";
    }
}

/**
 * Validates email field. Gives feedback when invalid.
 *
 * @returns {boolean} True when Email is valid
 */
function validateEmail() {
    email = document.getElementById("email");
    feedback = email.nextElementSibling;
    validEmail = /^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,6}$/.test(email.value);
    valid = true;
    if(!validEmail){
        markInputError(email);
        valid = false;
    }
    else{
        markInputSuccess(email);
    }
    return valid;
}

/**
 * Validates Username. Gives feedback when invalid.
 *
 * @returns {boolean} True when Username is valid
 */
function validateUsername() {
    uname = document.getElementById('userName');
    feedback = email.nextElementSibling;
    length = uname.value.length;
    valid = true;
    if(length < 5){
        markInputError(uname);
        valid = false;
    }
    else{
        markInputSuccess(uname);
    }
    return valid;
}

/**
 * Validates User password. Must be between 6 and 72 (inclusive) characters.
 * Also validates password confirmation
 *
 * @returns {boolean}
 */
function validatePassword() {
    upass = document.getElementById('userPassword');
    upassconf = document.getElementById('userPasswordConf');
    passLength = upass.value.length;
    valid = true;
    if(passLength>72 || passLength < 6){
        markInputError(upass);
        valid = false;
    }
    else{
        markInputSuccess(upass);
    }
    if(upass.value != upassconf.value){
        markInputError(upassconf);
        valid = false;
    }
    else{
        markInputSuccess(upassconf);
    }
    return valid;
}


function validateGender() {
    gender = document.getElementById('gender');
    genderList = [];
    valid = true;
    for(var i=0; i<gender.options.length; i++){
        if(gender[i].selected){
            genderList.push(gender[i].value)
        }
    }
    if(genderList.length<1){
        markInputError(gender);
    }
    else{
        markInputSuccess(gender);
    }
    if(genderList.indexOf('DTS')!=-1){
        if(genderList.length>1){
            markInputError(gender);
            valid = false;
        }
    }
    return valid;
}


function validatePronouns() {
    pronouns = document.getElementById('pronouns');
    valid = true;
    if(pronouns.value=='other'){
        subjP = document.getElementById('subjectP');
        objP = document.getElementById('objectP');
        possDetP = document.getElementById('possDetP');
        possP = document.getElementById('possP');
        reflexP = document.getElementById('reflexP');

        if(subjP.value.length<1 || subjP.value.length>10){
            markInputError(subjP);
            valid = false;
        }
        else{
            markInputSuccess(subjP);
        }

        if(objP.value.length<1 || objP.value.length>10){
            markInputError(objP);
            valid = false;
        }
        else{
            markInputSuccess(objP);
        }

        if(possDetP.value.length<1 || possDetP.value.length>10){
            markInputError(possDetP);
            valid = false;
        }
        else{
            markInputSuccess(possDetP);
        }

        if(possP.value.length<1 || possP.value.length>10){
            markInputError(possP);
            valid = false;
        }
        else{
            markInputSuccess(possP);
        }

        if(reflexP.value.length<1 || reflexP.value.length>10){
            markInputError(reflexP);
            valid = false;
        }
        else{
            markInputSuccess(reflexP);
        }
    }
    else {
        if (pronouns.value == 'def') {
            markInputError(pronouns);
            valid = false;
        }
        else {
            markInputSuccess(pronouns);
        }
    }
    return valid;
}

/**
 * Adds a CSS Class to the given element's class listing. (Does not add duplicates)
 *
 * @param elem      The element to have a class added to
 * @param CSSClass  The CSS class to add to elem
 */
function addCSSClass(elem, CSSClass){
    classRegEx = new RegExp("(?:^|\\s)"+CSSClass+"(?!\\S)", 'g');
    if(!classRegEx.test(elem.className)) {
        elem.className += " " + CSSClass;
    }
}

/**
 * Removes a CSS Class from the given element's class listing.
 *
 * @param elem      The element to have a class removed from
 * @param CSSClass  The CSS class to be removed from elem
 */
function removeCSSClass(elem, CSSClass){
    classRegEx = new RegExp("(?:^|\\s)"+CSSClass+"(?!\\S)", 'g');
    elem.className = elem.className.replace( classRegEx , '' );
}

/**
 * Marks a given input element as error. Markup must follow Bootstrap guidelines. (Glyphicon optional)
 * i.e.
 * <div class='form-group' ...>
 *     <input ...>
 *     <span class='glyphicon' ...>
 * </div>
 * @param elem The input element to be marked
 */
function markInputError(elem){
    feedback = elem.nextElementSibling;
    if(feedback.tagName!="span"){
        feedback = feedback.nextElementSibling;
    }
    addCSSClass(elem.parentNode, 'has-error');
    removeCSSClass(elem.parentNode, 'has-success');
    if(feedback!=null) {
        removeCSSClass(feedback, 'glyphicon-ok');
        addCSSClass(feedback, 'glyphicon-remove');
    }
}

/**
 * Marks a given input element as success. Markup must follow Bootstrap guidelines
 * i.e.
 * <div class='form-group' ...>
 *     <input ...>
 *     <span class='glyphicon' ...>
 * </div>
 * @param elem The input element to be marked
 */
function markInputSuccess(elem){
    feedback = elem.nextElementSibling;
    if(feedback.tagName!="span"){
        feedback = feedback.nextElementSibling;
    }
    removeCSSClass(elem.parentNode, 'has-error');
    addCSSClass(elem.parentNode, 'has-success');
    if(feedback!=null) {
        addCSSClass(feedback, 'glyphicon-ok');
        removeCSSClass(feedback, 'glyphicon-remove');
    }
}