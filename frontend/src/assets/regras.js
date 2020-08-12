var validate$0 = function (value, _a) {
    var length = _a.length;
    
    var strVal = String(value);
    return /[0-9]{11}/.test(strVal) && strVal.length === 11;
};


var cpf = {
    validate: validate$0
};

export {cpf};
