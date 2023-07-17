!function(e) {
    const baseUrl = 'https://chat.docs2ai.com'
    var expand = document.querySelector('script[data-expand]').dataset.expand;
    var collape = document.querySelector('script[data-collapse]').dataset.collapse;
    var color = document.querySelector('script[data-color]').dataset.color;


    const svgLogo = "<img src="+collape+">";

    const closeLogo = "<img src="+expand+">";


    const styles = ".bot-iframe-visible {\n" +
        "    display: block !important\n" +
        "}\n" +
        "\n" +
        "#bot-iframe-container {\n" +
        "    z-index: 99999;\n" +
        "    transition: visibility .5s, opacity .5s linear;\n" +
        "    background-color: #fff;\n" +
        "    position: fixed;\n" +
        "    right: 0;\n" +
        "    bottom: 0;\n" +
        "    height: 100%;\n" +
        "    width:65vw;\n" +
        "    border-radius: 10px;\n" +
        "    border: 1px solid rgba(0, 0, 0, 0.05);\n" +
        "    overflow: hidden;\n" +
        "    display: none\n" +
        "}\n" +
        "@media only screen and (max-width: 600px) {" +
        "#bot-iframe-container {" +
        "height:100%;" +
        "width:100%;" +
        "right:0;" +
        "left:0;" +
        "bottom:0;" +
            "}" +
          "}"
        +
        "#bot-iframe-container,\n" +
        "#bot-launcher:hover {\n" +
        "    box-shadow: 0 2px 4px rgba(0, 18, 26, .08), 0 3px 12px rgba(0, 18, 26, .16), 0 2px 14px 0 rgba(0, 18, 26, .2)\n" +
        "}\n" +
        "\n" +
        "#bot-iframe-container iframe {\n" +
        "    width: 100%;\n" +
        "    height: 100%;\n" +
        "    border: none\n" +
        "}\n" +
        "\n" +
        "#bot-launcher {\n" +
        "    box-shadow: 0 2px 4px rgba(0, 18, 26, .08), 0 2px 16px rgba(0, 18, 26, .16);\n" +
        "    z-index: 2147482999 !important;\n" +
        "    position: fixed !important;\n" +
        "    bottom: 20px;\n" +
        "    right: 20px;\n" +
        "    height: 56px !important;\n" +
        "    width: 56px !important;\n" +
        "    border-radius: 100px !important;\n" +
        "    overflow: hidden !important;\n" +
        "    background: "+color+" !important;\n" +
        "    border: 1px solid "+color+";\n" +
        "    opacity: .9;\n" +
        "    transition: box-shadow .26s cubic-bezier(.38, 0, .22, 1), opacity .26s ease-in-out;\n" +
        "    text-align: center;\n" +
        "    display: flex;\n" +
        "}\n" +
        "\n" +
        "#bot-launcher:hover {\n" +
        "    cursor: pointer;\n" +
        "    opacity: 1;\n" +
        "}\n" +
        "\n" +
        "#bot-launcher svg {\n" +
        "    width: 75%;\n" +
        "    height: auto;\n" +
        "    margin: auto;\n" +
        "    @media only screen and (max-width: 600px) {\n" +
        "        #bot-iframe-container {\n" +
        "            position:fixed;\n" +
        "            right: 5vw;\n" +
        "            bottom: 100px;\n" +
        "            height: 500px;\n" +
        "            width: 90vw;\n" +
        "            border-radius: 10px;\n" +
        "            overflow: hidden;\n" +
        "            display: none\n" +
        "        }\n" +
        "    }";



    var windowWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
    var windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;


    var styleSheet = document.createElement("style")
    styleSheet.innerText = styles
    document.head.appendChild(styleSheet)

    var mainContainer = document.createElement("div")
    mainContainer.setAttribute("id", "bot-wrapper")

    var iframeContainer = document.createElement("div")
    iframeContainer.setAttribute("id", "bot-iframe-container")

    var iframe = document.createElement("iframe");



    iframe.setAttribute("src", baseUrl + '?widget=' + window.justAddBotsSettings.widget_id+"&f=popup")

    var launcher = document.createElement("div")
    launcher.setAttribute("id", "bot-launcher")
    launcher.innerHTML = svgLogo
    launcher.addEventListener("click", function () {
        if ( iframeContainer.getAttribute("class") === "bot-iframe-visible") {
            iframeContainer.setAttribute("class", "")
            launcher.innerHTML = svgLogo;
            launcher.style.top = 'auto';
            launcher.style.right = '20px';
            launcher.style.bottom = '20px';
            launcher.style.background = 'none !important';
            launcher.style.boxShadow = 'none !important';
        }else{
            iframeContainer.setAttribute("class", "bot-iframe-visible")
            launcher.innerHTML = closeLogo;
            launcher.style.top = 0;
            launcher.style.right = 0;
            launcher.style.bottom = 'auto';
            launcher.style.background = 'none !important';
            launcher.style.boxShadow = 'none !important';
        }
    })

    iframeContainer.appendChild(iframe)
    mainContainer.appendChild(iframeContainer)
    mainContainer.appendChild(launcher)

    document.body.appendChild(mainContainer)
}()
