    (function () {
        window.siqConfig = {
            engineKey: "f011ec2f1b84f0d93574922d88a92600",
            forceLoadSettings: false        // change false to true if search box on your site is adding dynamically
        };
        window.siqConfig.baseUrl = "//pub.searchiq.co/";
        var script = document.createElement("SCRIPT");
        script.src = window.siqConfig.baseUrl + '/js/container/siq-container-2.js?cb=' + (Math.floor(Math.random()*999999)) + '&engineKey=' + siqConfig.engineKey;
        script.id = "siq-container";
        document.getElementsByTagName("HEAD")[0].appendChild(script);
    })();
