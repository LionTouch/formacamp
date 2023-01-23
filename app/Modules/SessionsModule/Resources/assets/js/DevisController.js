app.controller('DevisController',function($scope,$http,apiUrl,CurrentUser,Notification,$routeParams){
    /***************************************************************************************************
     ***************************************** Start Controller ****************************************
     *************************************************************************************************** */
    /**
     * VAR data table (limit data..)
     * */

    $scope.ins = {
        DATE:' 28 octobre 2021',
        DESTINATAIRE:'Tristan BAGAZA',
        LIEU_DESTINATAIRE:'23 Promenade Maxime Gerki 78500 SARTROUVILLE',
        NOM_ORGANISME:' FRC Technique',
        LIEU_SERVICE_ORGANISME:'4 Avenue de la Libération 60160MONTATAIRE',
        SIRET_ORGANISME:'88070475400022',
        REPRESENTANT:'Tatiana TROUSSELLE',
    }

    // $http({
    //     method: 'GET',
    //     url: apiUrl + 'FormaCampAPI/Devis/'+($routeParams.session_id || $scope.ins.ID_CLIENT),
    //     headers: {'Content-Type': undefined}
    // }).then(function (response) {
    //
    // });
    $scope.Print = function () {
        var innerContents = document.getElementById('constat').innerHTML;
        var popupWinindow = window.open('', '_blank', 'width=600,height=700,scrollbars=no,menubar=no,toolbar=no,location=no,status=no,titlebar=no');
        popupWinindow.document.open();
        popupWinindow.document.write('<html><head> <link rel="stylesheet" href="../resources/assets/css/bootstrap.min.css" media="print">' +
            '<style>@media print {\n' +
            ' header {\n' +
            '    width:100%;position: fixed;\n' +
            '    top: 0;\n' +
            '  }' +
            '.iq-card{' +
            'margin-top: 150px}' +
            '.page-break {page-break-before: always;}\n' +
            '    }</style>' +
            '</head><header><img src="../resources/assets/images/header.jpg" style="width: 100%"/>\n' +
            '            <div style="position:absolute;margin-left: 41%;top: 10px;color: #ffffff">\n' +
            '                <p>Siège social : 212 Avenue de Tivoli - 33110 Le Bouscat</p>\n' +
            '                <p>Numéro téléphone : 06.50.14.32.52</p>\n' +
            '                <p>Siren : 903.001.899</p>\n' +
            '            </div></header><body  onload="window.print()">' + innerContents + '</body></html>');
        popupWinindow.document.close();
    }
    var callBack = function(){
        $('.k-loading').removeClass('show')
    }
    $scope.Download = function () {
        $('.k-loading').addClass('show')
        kendo.drawing.drawDOM('#constat', {
            allPages: true,
            margin: { left: "0cm", top: "3cm", right: "0cm", bottom: "1cm" },
            forcePageBreak: ".page-break",
            keepTogether: ".prevent-split",
            paperSize: "A4",
            template: $("#page-template").html(),
            scale: 0.7

        }).then(function(group) {
            kendo.drawing.pdf.saveAs(group, "constat.pdf","",callBack);
        });
        kendo.pdf.defineFont({
            "DejaVu Sans"             : "resources/assets/fonts/DejaVuSans.ttf",
            "DejaVu Sans|Bold"        : "resources/assets/fonts/DejaVuSans-Bold.ttf",
            "DejaVu Sans|Bold|Italic" : "resources/assets/fonts/DejaVuSans-Oblique.ttf",
            "DejaVu Sans|Italic"      : "resources/assets/fonts/DejaVuSans-Oblique.ttf"
        });
    }

    /***************************************************************************************************
     ***************************************** End Controller ****************************************
     *************************************************************************************************** */
});
