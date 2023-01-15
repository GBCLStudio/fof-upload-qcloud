<div id="dplayer_{@uuid}" style="height: auto; width: auto"></div>

<script src="https://cdn.jsdelivr.net/npm/dplayer@1.27.0/dist/DPlayer.min.js"></script>
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
            url: "{@url}",
        },
    });
</script>
</body>
</html>
