function createPDF() {
    var doc = new jsPDF(); 
    var elementHandler = {
      '.ignorePDF': function (element, renderer) {
        return true;
      }
    };
    var source = window.document.getElementById('printtext'); //apelez HTML ul care trebuie adaugat in pdf
    
    //cu functia fromHTML generez pdf ul
    doc.fromHTML(
        source,
        15,
        15,
        {
          'width': 180,'elementHandlers': elementHandler
        });
    
    doc.save(); //pt download
}