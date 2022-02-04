import "./css/style.css";
import {Chrono} from "./js/Chrono.js";

const items = document.querySelectorAll(".item");

for(const item of items){
    new Chrono(item);

}