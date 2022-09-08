function click_on_link(i){
    switch(i){
        case 1:
            window.location.href = "index.php";
            document.getElementById("test").innerHTML = "1";

            break;
        case 2:
            window.location.href = "About_us.php";
            document.getElementById("test").innerHTML = "2";

            break;
        case 3:
            document.getElementById("test").innerHTML = "3";

            window.location.href = "Our_project.php";
            break;
    }
    // document.getElementById("test").innerHTML = i;
}