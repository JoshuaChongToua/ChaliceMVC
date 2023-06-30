function getImageSelect (string)
{
    if (string == "--"){
        document.getElementById("test").innerHTML = "";

    } else {

            var imgElement = document.createElement("img");
            var imgPath = "/admin/includes/assets/images/upload/" + string.trim() + ".jpg";
            imgElement.src = imgPath;
            imgElement.style.width = "100px";
            imgElement.style.height = "100px";
            document.getElementById("test").innerHTML = "";
            document.getElementById("test").appendChild(imgElement);

    }

}
function getImageProfileSelect (string)
{
    if (string == ""){
        document.getElementById("test").innerHTML = "";

    } else {
        var imgElement = document.createElement("img");
        const id = document.getElementById("user_id").value;
        var imgPath = "includes/assets/images/profiles/"+ id + "/" + string + ".jpg" ;
        imgElement.src = imgPath;
        console.log("Chemin de l'image : " + imgElement.src);

        document.getElementById("test").innerHTML = "";
        document.getElementById("test").appendChild(imgElement);
    }
}
