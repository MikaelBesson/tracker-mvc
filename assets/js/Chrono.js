
import AjaxMaker from "ajax-maker/src/AjaxMaker";

export class Chrono {

    constructor(element) {
        this.element = element;
        this.id = this.element.id;
        if(this.element.dataset.time !== "0"){
            const d = this.element.dataset.time.indexOf("d");
            const h = this.element.dataset.time.indexOf("h");
            const m = this.element.dataset.time.indexOf("m");

            this.d = '';
            for(let i = 0; i<d; i++){
                this.d += this.element.dataset.time[i];
            }
            console.log(this.d);
            this.d = parseInt(this.d);


            this.h = '';
            for(let i = d+2; i<h; i++){
                this.h += this.element.dataset.time[i];
            }
            console.log(this.h);
            this.h = parseInt(this.h);


            this.m = '';
            for(let i = h+2; i<m; i++){
                this.m += this.element.dataset.time[i];
            }
            console.log(this.m);
            this.m = parseInt(this.m);


            this.s = '';
            for(let i = m+2; i<this.element.dataset.time.length-1; i++){
                this.s += this.element.dataset.time[i];
            }
            console.log(this.s);
            this.s = parseInt(this.s);

        }
        else {
            this.d = 0;
            this.h = 0;
            this.m = 0;
            this.s = 0;
        }

        this.flagstart = false;
        this.event();
        this.time();
    }


    event(){
        const start = this.element.querySelector(".startstop");
        const reset = this.element.querySelector(".reset");

        start.addEventListener("click", ()=>{
            if(!this.flagstart){
                start.value = "stop";
                this.flagstart = true;
            }
            else {
                const req = new AjaxMaker("/item/update","POST",null,{"id":this.id, "time":`${this.d}d:${this.h}h:${this.m}m:${this.s}s`});
                req.send();
                start.value = "start";
                this.flagstart = false;
            }
        });
        reset.addEventListener("click", ()=>{
            const req = new AjaxMaker("/item/reset","POST", null, {"id":this.id});
            req.send();
            this.d = 0;
            this.h = 0;
            this.m = 0;
            this.s = 0;
            this.affichage();
        })
    }

    time(){
        setInterval(()=>{
            if(this.flagstart){
                this.s ++;

                if(this.s > 59){
                    this.s = 0;
                    this.m ++;

                    if(this.m > 59){
                        this.m =0;
                        this.h ++;

                        if(this.h > 23){
                            this.h = 0;
                            this.d ++;
                        }
                    }
                }
            }
            this.affichage();
        },10)
    }

    affichage(){
        const chronotime = this.element.querySelector(".chronotime");
        chronotime.innerHTML = `${this.d}d:${this.h}h:${this.m}m:${this.s}s`;
    }
}
