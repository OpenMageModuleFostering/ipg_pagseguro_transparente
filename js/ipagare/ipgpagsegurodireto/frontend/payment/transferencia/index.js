var x = 2;
var y = 1;
var financeira = null;

ipagare.startClock = function() {

    x = x - y;
    setTimeout("ipagare.startClock()", 1000);
    if (x == 0) {
        try {
            if (financeira.closed) {
                document.location.href = URL_VERIFY;
            } else {
                x = 1; // intervalo de segundos
            }
        } catch (e) {
            x = 1; // intervalo de segundos
        }
    }
};

ipagare.openPopup = function() {
    window.name = "IpagarePagSeguroDireto";
    financeira = window.open(URL_PAYMENT, 'formPagSeguroDireto', 'width=780,height=500,toolbar=0,location=0,directories=0,dependent=0,status=1,scrollbars=1,resizable=1');

    if (ipagare.isNotNull(financeira)) {
        ipagare.startClock();
    }
};
