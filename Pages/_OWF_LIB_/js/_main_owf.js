function linker(dst,tg,token,obj,com="imp",i=""){
    var req = new ReqJS(tg,"POST")

    req.setData([
        ["token",token.value],
        ["form",dst],
        ["id",i],
        ["com",com]
    ])

    req.send(a => {
        /*
            a = [status]            FAIL
            a = [token][obj]        SUCC
        */
        if(a == "false"){
            location.href = location.href;
        }else{
            token.value = a.substring(0,8);
            obj.innerHTML = a.substring(8,a.length);
        }
    })
}

function rester(dst,tg,p,token,obj,indp){
    var req = new ReqJS(tg,"POST")

    req.setData([
        ["token",token.value],
        ["res",dst],
        ["page",p]
    ])

    req.send(a => {
        token.value = a.substring(0,8);
        if(a.substring(8,13) == "false"){
            indp.innerHTML = p - 1;
            obj.innerHTML = a.substring(13,a.length);
        }else{
            obj.innerHTML = a.substring(8,a.length);
        }
    })
}

function workster(tg,token,com,field,id,val=[]){
    var req = new ReqJS(tg,"POST")

    var data = [
        ["token",token.value],
        ["com",com],
        ["page",field],
        ["id",id]
    ];

    val.forEach(i => {
        data.push(i)
    })

    req.setData(data);

    req.send(a => {
        if(a.length == 8){
            token.value = a;
        }else if(a.length > 8){
            token.value = a.substring(0,8);
            alert(a.substring(8,a.length));
        }else{
            token.value = "";
            alert("You don't have access to do action");
        }
    })
}

function download(text,name,type){
    var a = document.createElement('a');
    var file = new Blob([text], {type: type});
    a.href = URL.createObjectURL(file);
    a.download = name;
    a.click();
}

function ipCheck(e,o,a){
    if(e.key == "Enter"){
        var text = o.value;

        if(text.length < 7 || text.length > 15){
            alert("Invalid IP");
            return;
        }

        for(var i = 0; i < text.length; i++){
            if(!"1234567890.".includes(text[i])){
                alert("Invalid IP");
                return;
            }
        }

        var dot = 0;
        for(var i = 0; i < text.length; i++){
            if(text[i] == "."){
                dot++;
            }
        }
        if(dot != 3){
            alert("Invalid IP");
            return;
        }

        if(text[i] == "0" || text[i] == "."){
            alert("Invalid IP");
            return;
        }

        var tmpo = text.split(".");
        for(var i = 0; i < tmpo.length; i++){
            var int = parseInt(tmpo[i]);
            if(int >= 256 || int < 0){
                alert("Invalid IP");
                return;
            }
            
            if(tmpo[i][0] == "0" && tmpo[i].length > 1){
                alert("Invalid IP");
                return;
            }
        }

        o.value = "";
        a.innerHTML += "<div class=\"olo font-it\" onclick=\"this.remove()\">"+text+"</div>";
    }
}

function urlNaming(e,o,a){
    if(e.key == "Enter"){
        if(o.value[0] != "/" && o.value[0] != "\\"){
            alert("Invalid URL");
            return;
        }

        if(o.value.includes("?") || o.value.includes(" ")){
            alert("Invalid URL");
            return;
        }

        a.innerHTML += "<div class=\"olo font-it\" onclick=\"this.remove()\">"+o.value+"</div>";
        o.value = "";
    }
}