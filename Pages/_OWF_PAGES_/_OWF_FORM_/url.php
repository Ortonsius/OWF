<?php
Importer::import(Control::$dir."/Pages/_OWF_API_/api_lib/ApiSec.php");
_OWF_AUTH::credentialCheck();

$fwlist = _NOT_::getJson(Control::$dir."/data/firewall_ls.json");

?>
<p class="form-title font-it">URL</p>
<section class="owf-form" style="overflow-y: auto; height: 70%;">
    <div class="opt-list">
        <input type="text" class="owf-txt font-it" id="owf-url" placeholder="URL" onkeypress="urlNaming(event,this,document.querySelector('#owf-ul'))">
        <p class="font-it">URL</p>
        <br>
        <div class="olist" id="owf-ul">
        </div>
    </div>
    <div class="opt-list">
        <p class="font-it">Method</p>
        <div class="olist" id="owf-method">
            <?php
                $ml = ["GET","POST","OPTIONS","PUT","HEAD","DELETE","CONNECT","TRACE","PATCH"];
                foreach($ml as $k){
                    ?>
                        <div class="olo font-it" id="false" onclick="
                            if(this.id == 'false'){
                                this.id = 'true';
                                this.style = 'background: #101010; color: #f0f0f0';
                            }else{
                                this.id = 'false';
                                this.style = 'background: none; color: #101010';
                            }
                        "><?= $k; ?></div>
                    <?php
                }
            ?>
        </div>
    </div>
    <select id="owf-type" class="selection-owf" style="width: 50%;">
        <option value="text/html">HTML/PHP</option>
        <option value="text/plain">TXT</option>
        <option value="text/javascript">JS</option>
        <option value="text/css">CSS</option>
        <option value="image/gif">GIF</option>
        <option value="image/jpeg">JPEG</option>
        <option value="application/json">JSON</option>
        <option value="audio/wav">WAV</option>
        <option value="application/zip">ZIP</option>
        <option value="text/csv">CSV</option>
        <option value="application/msword">MSWORD</option>
        <option value="image/*">Image ...</option>
        <option value="application/*">Application ...</option>
        <option value="video/*">Video ...</option>
        <option value="audio/*">Audio ...</option>
        <option value="font/*">Font ...</option>
        <option value="text/*">Text ...</option>
    </select>
    <div class="opt-list">
        <p class="font-it">Firewall</p>
        <div class="olist" id="owf-fw">
            <?php
                foreach($fwlist as $k => $_){
                    ?>
                        <div class="olo font-it" id="false" onclick="
                            if(this.id == 'false'){
                                this.id = 'true';
                                this.style = 'background: #101010; color: #f0f0f0';
                            }else{
                                this.id = 'false';
                                this.style = 'background: none; color: #101010';
                            }
                        "><?= $k; ?></div>
                    <?php
                }
            ?>
        </div>
    </div>
    <div class="part">
        <select id="page-type" class="selection-owf" style="width: 30%;">
            <option value="public">PUBLIC</option>
            <option value="private">PRIVATE</option>
        </select>
        <div class="upl-owf" style="width: 60%;">
            <input type="file" class="owf-file font-it" id="owf-pf" onchange="document.querySelector('.upl-owf p').innerHTML = 'File included';">
            <p class="font-it">Upload file...</p>
        </div>
    </div>
    <div class="opt-list">
        <input type="text" class="owf-txt font-it" id="owf-ip" placeholder="IP" onkeypress="ipCheck(event,this,document.querySelector('#owf-ipl'))">
        <p class="font-it">IP</p>
        <br>
        <div class="olist" id="owf-ipl">
        </div>
    </div>
    <button class="owf-btn font-it" id="OWF_FORM_SUBMIT" onclick="
        let url = [];
        let fw = [];
        let ip = [];
        let method = [];
        document.querySelectorAll('#owf-ul div').forEach(i => {
            url.push(i.innerHTML);
        });
        document.querySelectorAll('#owf-fw div').forEach(i => {
            if(i.id == 'true') fw.push(i.innerHTML);
        });
        document.querySelectorAll('#owf-ipl div').forEach(i => {
            ip.push(i.innerHTML);
        });
        document.querySelectorAll('#owf-method div').forEach(i => {
            if(i.id == 'true') method.push(i.innerHTML);
        });
        url = JSON.stringify(url);
        fw = JSON.stringify(fw);
        ip = JSON.stringify(ip);
        method = JSON.stringify(method);
        
        let type = document.querySelector('#owf-type').value;
        let ptype = document.querySelector('#page-type').value;
        let uf = document.querySelector('#owf-pf').files[0];


        workster('<?= Builder::BuildLink("_OWF_PAGES_/_OWF_WORKER.php",true); ?>',document.querySelector('#OWF_TOKEN_WORKER'),'add','URL',url,[['f',uf],['ctype',type],['ptype',ptype],['method',method],['ip',ip],['fw',fw]]);
        linker('URL','<?= Builder::BuildLink("_OWF_PAGES_/_OWF_FORM.php",true); ?>',document.querySelector('#OWF_TOKEN_FORM'),cform);
        rester('URL','<?= Builder::BuildLink("_OWF_PAGES_/_OWF_RES.php",true); ?>',indexPage.innerHTML,resToken,resPage,indexPage)
    ">ADD</button>
</section>