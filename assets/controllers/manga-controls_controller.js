import { Controller } from '@hotwired/stimulus';
import axios from "axios";

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * manga-controls_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        let a, b, c;
        function toggle(i) {
            if (i) {i = false
            }else {i = true}
        }

        if (a) {
            document.getElementsByClassName('a').style.visibility='shown';
        }else {
            document.getElementsByClassName('a').style.visibility='hidden';
        }

        if (b) {
            document.getElementsByClassName('b').style.visibility='shown';
        }else {
            document.getElementsByClassName('b').style.visibility='hidden';
        }

        if (c) {
            document.getElementsByClassName('c').style.visibility='shown';
        }else {
            document.getElementsByClassName('c').style.visibility='hidden';
        }
    }
}
