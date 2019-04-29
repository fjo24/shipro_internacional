function suma(){
    var weight=Number(document.getElementById('weight').value);
    var long=Number(document.getElementById('long').value);
    var height=Number(document.getElementById('height').value);
    var width=Number(document.getElementById('width').value);
    var volumetric_weight=long*height*width/5000;
    document.getElementById('volumetric_weight').value=volumetric_weight;

    if (weight > volumetric_weight) {
        var total=weight;
        document.getElementById('resultado').innerHTML = total;
        document.getElementById('total').value=weight;
    }else {
        var total=volumetric_weight;
        document.getElementById('resultado').innerHTML = total;
        document.getElementById('total').value=volumetric_weight;
    }
}