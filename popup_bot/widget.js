!function(e) {
    const baseUrl = window.justAddBotsSettings.base_url || 'https://chat.docs2ai.com'
    const svgLogo = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n" +
        "\n" +
        "<!-- Uploaded to: SVG Repo, www.svgrepo.com, Generator: SVG Repo Mixer Tools -->\n" +
        "<svg width=\"800px\" height=\"800px\" viewBox=\"0 0 24 24\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\">\n" +
        "<g id=\"Communication / Chat_Circle_Dots\">\n" +
        "<path id=\"Vector\" d=\"M7.50977 19.8018C8.83126 20.5639 10.3645 21 11.9996 21C16.9702 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 13.6351 3.43604 15.1684 4.19819 16.4899L4.20114 16.495C4.27448 16.6221 4.31146 16.6863 4.32821 16.7469C4.34401 16.804 4.34842 16.8554 4.34437 16.9146C4.34003 16.9781 4.3186 17.044 4.27468 17.1758L3.50586 19.4823L3.50489 19.4853C3.34268 19.9719 3.26157 20.2152 3.31938 20.3774C3.36979 20.5187 3.48169 20.6303 3.62305 20.6807C3.78482 20.7384 4.02705 20.6577 4.51155 20.4962L4.51758 20.4939L6.82405 19.7251C6.95537 19.6813 7.02214 19.6591 7.08559 19.6548C7.14475 19.6507 7.19578 19.6561 7.25293 19.6719C7.31368 19.6887 7.37783 19.7257 7.50563 19.7994L7.50977 19.8018Z\" stroke=\"#000000\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"/>\n" +
        "</g>\n" +
        "</svg>";
    const styles = '.bot-iframe-visible{display:block!important}#bot-iframe-container{z-index:99999; transition:visibility .5s,opacity .5s linear;background-color:#fff;position:fixed;right:20px;bottom:90px;height:500px;width:400px;border-radius:10px;border:1px solid rgba(0, 0, 0, 0.05);overflow:hidden;display:none}#bot-iframe-container,#bot-launcher:hover{box-shadow:0 2px 4px rgba(0,18,26,.08),0 3px 12px rgba(0,18,26,.16),0 2px 14px 0 rgba(0,18,26,.2)}#bot-iframe-container iframe{width:100%;height:100%;border:none}#bot-launcher{box-shadow:0 2px 4px rgba(0,18,26,.08),0 2px 16px rgba(0,18,26,.16);z-index:2147482999!important;position:fixed!important;bottom:20px;right:20px;height:56px!important;width:56px!important;border-radius:100px!important;overflow:hidden!important;background:#c9c5fd!important;border:1px solid ##000;opacity:.9;transition:box-shadow .26s cubic-bezier(.38, 0, .22, 1),opacity .26s ease-in-out;text-align:center;display:flex;}#bot-launcher:hover{cursor:pointer;opacity:1;}#bot-launcher svg{width:75%;height:auto;margin:auto;@media only screen and (max-width:600px){#bot-iframe-container{position:fixed;right:5vw;bottom:100px;height:500px;width:90vw;border-radius:10px;overflow:hidden;display:none}}'

    var styleSheet = document.createElement("style")
    styleSheet.innerText = styles
    document.head.appendChild(styleSheet)

    var mainContainer = document.createElement("div")
    mainContainer.setAttribute("id", "bot-wrapper")

    var iframeContainer = document.createElement("div")
    iframeContainer.setAttribute("id", "bot-iframe-container")

    var iframe = document.createElement("iframe");
    iframe.setAttribute("src", baseUrl + '?widget=' + window.justAddBotsSettings.widget_id)

    var launcher = document.createElement("div")
    launcher.setAttribute("id", "bot-launcher")
    launcher.innerHTML = svgLogo
    launcher.addEventListener("click", function () {
        if ( iframeContainer.getAttribute("class") === "bot-iframe-visible") {
            iframeContainer.setAttribute("class", "")
        }else{
            iframeContainer.setAttribute("class", "bot-iframe-visible")
        }
    })

    iframeContainer.appendChild(iframe)
    mainContainer.appendChild(iframeContainer)
    mainContainer.appendChild(launcher)

    document.body.appendChild(mainContainer)
}()