// JavaScript Document
$(document).ready( function () {
$('#DailySummaryTable').dataTable( {
  "searching": false,
  "lengthChange": false,
  "responsive": true,
  "iDisplayLength": 5,
  "ordering": false,
  "info": false
} );
} );

$(document).ready( function () {
$('#NodesTable').dataTable( {
  "searching": false,
  "lengthChange": false,
  "responsive": true,
  "ordering": false
} );
} );

$(document).ready( function () {
$('#LogTable').dataTable( {
  "searching": true,
  "lengthChange": true,
  "responsive": true,
  "iDisplayLength": 50,
  "ordering": false,
  "info": true
} );
} );