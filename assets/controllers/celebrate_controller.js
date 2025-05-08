import { Controller } from "@hotwired/stimulus";
import JSConfetti from "js-confetti";

/* stimulusFetch: 'lazy' */
// Connects to data-controller="celebrate"
export default class extends Controller {
	poof() {
		const jsConfetti = new JSConfetti();
		//jsConfetti.addConfetti();
        jsConfetti.addConfetti({
					emojis: ["👽", "👾", "🤖", "🛸"  ],
					emojiSize: 50,
					confettiNumber: 100,
				});
	}
}
