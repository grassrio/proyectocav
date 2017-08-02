<?php
require('includes/loginheader.php');
session_start();
if (isset($_SESSION['usuario'])) {?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    
    <link href="css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico" />
    <link href="css/todc-bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="css/sweetalert.css" />


    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/sweetalert.min.js"></script>
    <script src="js/validator.min.js"></script>

    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.0/bootstrap-table.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.9.1/extensions/editable/bootstrap-table-editable.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.9.1/extensions/export/bootstrap-table-export.js"></script>
    <script src="http://rawgit.com/hhurz/tableExport.jquery.plugin/master/tableExport.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.9.1/extensions/filter-control/bootstrap-table-filter-control.js"></script>

    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.0/bootstrap-table.min.css" />
    <link rel="stylesheet" type="text/css" href="http://rawgit.com/vitalets/x-editable/master/dist/bootstrap3-editable/css/bootstrap-editable.css" />
</head>
<body>
    
    <script type="text/javascript">
//exporte les données sélectionnées
var $table = $('#table');
    $(function () {
        $('#toolbar').find('select').change(function () {
            $table.bootstrapTable('refreshOptions', {
                exportDataType: $(this).val()
            });
        });
    })

		var trBoldBlue = $("table");

	$(trBoldBlue).on("click", "tr", function (){
			$(this).toggleClass("bold-blue");
	});
    </script>


    <div class="container">
        <div id="toolbar">
            <select class="form-control">
                <option value="">Export Basic</option>
                <option value="all">Export All</option>
                <option value="selected">Export Selected</option>
            </select>
        </div>

        <table id="table"
               data-toggle="table"
               data-search="true"
               data-filter-control="true"
               data-show-export="true"
               data-click-to-select="true"
               data-toolbar="#toolbar">
            <thead>
                <tr>
                    <th data-field="state" data-checkbox="true"></th>
                    <th data-field="prenom" data-filter-control="input" data-sortable="true">Prénom</th>
                    <th data-field="date" data-filter-control="select" data-sortable="true">Date</th>
                    <th data-field="examen" data-filter-control="select" data-sortable="true">Examen</th>
                    <th data-field="note" data-sortable="true">Note</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="bs-checkbox "><input data-index="0" name="btSelectItem" type="checkbox"></td>
                    <td>Valérie</td>
                    <td>01/09/2015</td>
                    <td>Français</td>
                    <td>12/20</td>
                </tr>
                <tr>
                    <td class="bs-checkbox "><input data-index="1" name="btSelectItem" type="checkbox"></td>
                    <td>Eric</td>
                    <td>05/09/2015</td>
                    <td>Philosophie</td>
                    <td>8/20</td>
                </tr>
                <tr>
                    <td class="bs-checkbox "><input data-index="2" name="btSelectItem" type="checkbox"></td>
                    <td>Valentin</td>
                    <td>05/09/2015</td>
                    <td>Philosophie</td>
                    <td>4/20</td>
                </tr>
                <tr>
                    <td class="bs-checkbox "><input data-index="3" name="btSelectItem" type="checkbox"></td>
                    <td>Valérie</td>
                    <td>05/09/2015</td>
                    <td>Philosophie</td>
                    <td>10/20</td>
                </tr>
                <tr>
                    <td class="bs-checkbox "><input data-index="4" name="btSelectItem" type="checkbox"></td>
                    <td>Eric</td>
                    <td>01/09/2015</td>
                    <td>Français</td>
                    <td>14/20</td>
                </tr>
                <tr>
                    <td class="bs-checkbox "><input data-index="5" name="btSelectItem" type="checkbox"></td>
                    <td>Valérie</td>
                    <td>07/09/2015</td>
                    <td>Mathématiques</td>
                    <td>19/20</td>
                </tr>
                <tr>
                    <td class="bs-checkbox "><input data-index="6" name="btSelectItem" type="checkbox"></td>
                    <td>Valentin</td>
                    <td>01/09/2015</td>
                    <td>Français</td>
                    <td>11/20</td>
                </tr>
                <tr>
                    <td class="bs-checkbox "><input data-index="7" name="btSelectItem" type="checkbox"></td>
                    <td>Eric</td>
                    <td>01/10/2015</td>
                    <td>Philosophie</td>
                    <td>8/20</td>
                </tr>
                <tr>
                    <td class="bs-checkbox "><input data-index="8" name="btSelectItem" type="checkbox"></td>
                    <td>Valentin</td>
                    <td>07/09/2015</td>
                    <td>Mathématiques</td>
                    <td>14/20</td>
                </tr>
                <tr>
                    <td class="bs-checkbox "><input data-index="9" name="btSelectItem" type="checkbox"></td>
                    <td>Valérie</td>
                    <td>01/10/2015</td>
                    <td>Philosophie</td>
                    <td>12/20</td>
                </tr>
                <tr>
                    <td class="bs-checkbox "><input data-index="10" name="btSelectItem" type="checkbox"></td>
                    <td>Eric</td>
                    <td>07/09/2015</td>
                    <td>Mathématiques</td>
                    <td>14/20</td>
                </tr>
                <tr>
                    <td class="bs-checkbox "><input data-index="11" name="btSelectItem" type="checkbox"></td>
                    <td>Valentin</td>
                    <td>01/10/2015</td>
                    <td>Philosophie</td>
                    <td>10/20</td>
                </tr>
            </tbody>
        </table>
    </div>

</body>


</html>
<?php } ?>