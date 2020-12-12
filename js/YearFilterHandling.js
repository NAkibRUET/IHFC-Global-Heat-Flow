function YearFilterHandling() {
  //console.log("addad");
  var x = document.getElementById("select_year").value;
  console.log(x);
  window.location = `index.php?year=${x}`;
}
