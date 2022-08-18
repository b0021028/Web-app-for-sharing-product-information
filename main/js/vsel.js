
/*
function Load(ASviewer){
        try {
            ASviewer.Load()
        }
        catch{
            //window.setTimeout(function (){Load(ASviewer);},100*ASviewer.flag+100);
        }
    }
class AjaxSelectviewer{

    constructor(t, text, docElement){
        this.t = t;
        this.flag = 0;
        this.__v = text;
        this.size = 0;
        this.docElement = docElement
    }


    Cooldown(text){
        this.flag += 1;
        if (this.flag <= 1){
            this.t.open('GET',text);
            this.t.send();
            this.Loader();
        } else {
            return this.flag -= 1;
        }
    }

    fetchertest(txt){
        let s = new Request(txt);
        fetch(s, {method: 'GET'});
    
    
    }
    Loader(){
        if (this.t.readyState === 4 && this.t.status === 200) {
            this.__Load(this.docElement);
        }else{
            this.__Load(this.docElement);
            console.log("AjaxSelectviewer error : not conected > pleas wait or redo")
            //throw new Error("AjaxSelectviewer error : not conected > pleas wait or redo");
        }
    }
    __Load(){
        //https://riss.ipa.go.jp/
        //http://www.htmq.com/webstorage/ 
        this.docElement.innerHTML = "";//.toString();
        let jsondata = JSON.parse(this.t.responseText.toString());
        let x,key
        console.log(jsondata)
        for (x in jsondata["values"]){
            this.docElement.innerHTML +="<br><li><a onclick='getVal(size)'><input type='button' value='更新' ></input></a><br>";
            for (key in jsondata["key"]){
                this.docElement.innerHTML += jsondata["key"][key];
                this.docElement.innerHTML += " : ";
                if (key == "PRICE"){
                    this.docElement.innerHTML += `${jsondata["type"]["currency"]["head"]} ${jsondata["values"][x][key].toLocaleString(jsondata["type"]["locate"])}${jsondata["type"]["currency"]["foot"]}`
                }else{
                    this.docElement.innerHTML += jsondata["values"][x][key]||"---- - -- - --";
                }
                this.docElement.innerHTML +="<br>";
            }

            this.docElement.innerHTML += "</li>";
        }
        this.flag -= 1;
    }


    getVal(num){
        this.size = num;
        this.docElement.innerHTML = `./${this.__v}&page=${this.size}`;
        this.Cooldown(`./${this.__v}&page=${this.size}`);
    }
    //onreadystatechange
    /*
    let search = document.forms["search"];
    document.forms.search.user.value= "sugi"
    document.forms.search.password.value= "sugisugi"
    search.method = "GET"
    search.submit(); /
}*/



async function sleep(ms, func=null){
    await (new Promise(
        (resolve) => {setTimeout(resolve, ms);}
    ));
    if (func!=null){return func();}
    return true;
}


class AjaxSelectviewer{
    #flag = 0;
    #url = "";
    #page;
    #size;
    #searchkey;
    #docElement;
    constructor(text, docElement, fetchfunc=function(result){}){
        this.#flag = 0;
        this.#url = text;
        this.page = 0;
        this.size = 5;
        this.docElement = docElement;
        this.searchkey = "";
        this.fetchfunc = fetchfunc;
    }

    get docElement(){return this.#docElement}
    set docElement(val){
        if (val.constructor.name == "HTMLDivElement"){
            this.#docElement = val;
        }else{
            throw console.error();
        }
    }
    get #keywords(){
        return this.searchkey.replaceAll("\\","\\\\").replaceAll("&","\&").replaceAll("#","\#");
    }

    get searchkey(){return this.#searchkey;}
    set searchkey(val){this.#searchkey = String(val);}

    get page(){return this.#page;}
    set page(val){
        let tmp = parseInt(val);
        if (!isNaN(tmp))
            if (tmp < 0){
                tmp = 0;
            }
            this.#page = tmp;
    }
    get size(){return this.#size};
    set size(val){if (parseInt(val) > 0){this.#size = parseInt(val)}};

    
    Load(){
        this.#flag += 1;
        if (this.#flag == 1){
            console.log("Loading...")
            this.#Load()
        }
        else {
            this.#flag -= 1
            console.log("Now Loading Please wait")
        }
    }



    async #Load(){
        try {
            let jsondata = await (await fetch(`${this.#url}&page=${this.page}&keywords=${this.#keywords}`)).json();
            await this.fetchfunc(jsondata)
            this.page = jsondata["type"]["property"]["page"];
            console.log(jsondata)
            console.log("Loaded!"+"page"+this.page.toString())
        } catch(e) {console.log(e)}
        this.#flag -= 1;
    }

    getRecode(page=NaN){
        if (this.#flag == 0){
            if (isNaN(page) || page==null){ page = this.page}
            if (page <= 0){ page = 0;}
            this.page=page;
            this.Load();
        }
    }

    search(keywords=""){
        this.#flag += 1;
        if (this.#flag == 1){
            this.searchkey = keywords;
            this.page = 0
            this.#Load()
        }
        else {
            this.#flag -= 1
            console.log("Now Loading Please wait")
        }
    }

}
