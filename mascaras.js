let objeto, funcao;

function mascara(o,f){
    objeto = o;
    funcao = f;
    setTimeout(executaMascara, 1);
}

function executaMascara(){
    objeto.value = funcao(objeto.value);
}


function telefone(v) {
    v = v.replace(/\D/g, ""); 
    v = v.replace(/^(\d{2})(\d)/g, "($1) $2"); 
    v = v.replace(/(\d{4,5})(\d{4})$/, "$1-$2"); 
    return v;
}

