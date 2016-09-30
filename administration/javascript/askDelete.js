function askDelete(addr, params, nomFichier) {
  if(confirm('Voulez-vous vraiment supprimer ' + nomFichier + ' ?')) {
    var adresseLocale = getFolder();
    var formElem = document.createElement('form');
    formElem.method = "post";
    formElem.action = addr;
    for(var param_name in params) {
      var inputElem = document.createElement('input');
      inputElem.type  = "hidden";
      inputElem.name  = param_name;
      inputElem.value = params[param_name];
      formElem.appendChild(inputElem);
    }
    document.body.appendChild(formElem);
    refreshScrollOnForms();
    formElem.submit();
  }
}