var memDetails = document.querySelector('.memDetails');

function unsubListen() {
    var button = document.getElementById('confimSupMem');
    Listener(button, 'click', unsubLocation);
}

function unsubLocation() {
    window.location = '../php/index.php?EX=userSpace&USER_SPACE=unsubscribe';
}

if (memDetails) {
    var mailConfirm = document.getElementById('newMail2');
    var passConfirm = document.getElementById('newPwd2');
    var mailExists = document.querySelector('input[type=email][data-mail-exists]');
    var phoneNum = document.getElementById('phoneMemInp');
    
    var unsubBTN = document.getElementById('delAccount');
    
    Listener(mailExists, 'blur', testMailIsExists);
    Listener(mailConfirm, 'blur', mailTest);
    Listener(passConfirm, 'blur', passwordTest);
    Listener(phoneNum, 'keypress', isInteger)
    Listener(phoneNum, 'keypress', insertSpaceNumber)
    
    Listener(unsubBTN, 'click', unsubListen);
}