<div id="dplayer_{@uuid}" style="height: auto; width: auto"></div>

<script type="text/javascript">
    var dp = new DPlayer({
        container: document.getElementById("dplayer_{@uuid}"),
        theme: "#FFCCCC",
        volume: "0.7",
        loop: "true",
        lang: "zh-cn",
        live: false,
        mutex: false,
        hotkey: "true",
        video: {
            url: "{@preview_uri}",
        },
    });
</script>
</body>
</html>
