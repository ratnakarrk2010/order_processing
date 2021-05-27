function openNav() {
    if (document.getElementById("app-layout-drawer").className == "app-layout-drawer width_250") {
        var element = document.getElementById("app-layout-drawer");
        element.classList.remove("width_250");
        var element1 = document.getElementById("app-layout-content");
        element1.classList.remove("margin_left_250");
        var element8 = document.getElementById("app-layout-header");
        element8.classList.remove("margin_left_250");
        var element2 = document.getElementById("app-layout-drawer");
        element2.classList.add("width_0");
        var element3 = document.getElementById("app-layout-content");
        element3.classList.add("margin_left_0");
        //   var element5 = document.getElementById("framework11");
        //   element5.classList.remove("back_gr");
        var element7 = document.getElementById("app-layout-header");
        element7.classList.add("margin_left_0");

    }
    else {
        var element = document.getElementById("app-layout-drawer");
        element.classList.remove("width_0");
        var element2 = document.getElementById("app-layout-content");
        element2.classList.remove("margin_left_0");
        var element3 = document.getElementById("app-layout-drawer");
        element3.classList.add("width_250");
        var element9 = document.getElementById("app-layout-header");
        element9.classList.add("margin_left_0");
        var element4 = document.getElementById("app-layout-content");
        element4.classList.add("margin_left_250");
        //   var element6 = document.getElementById("framework11");
        //   element6.classList.add("back_gr");
        var element10 = document.getElementById("app-layout-header");
        element10.classList.add("margin_left_250");

    }
}
     