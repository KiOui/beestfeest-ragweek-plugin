

class AudioVisualizer {

    constructor(visualizer, audioContent, stream) {
        this.visualizer = visualizer;
        visualizer.setAttribute('viewBox', '0 0 255 255');
        this.running = false;
        this.audioStream = audioContent.createMediaStreamSource(stream);
        this.analyzer = audioContent.createAnalyser();
        this.analyzer.fftSize = 1024;
        this.audioStream.connect(this.analyzer);
        this.paths = [];
        let mask = this.visualizer.getElementById('mask');
        for (let i = 0; i < this.analyzer.frequencyBinCount; i++) {
            let path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
            path.setAttribute('stroke-dasharray', '4,1');
            mask.appendChild(path);
            this.paths.push(path);
        }
    }

    run() {
        this.running = true;
        this.doDraw();
    }

    stop() {
        this.running = false;
    }

    doDraw() {
        if (this.running) {
            requestAnimationFrame(() => {
                this.doDraw();
            });
            let frequencyArray = new Uint8Array(this.analyzer.frequencyBinCount);
            this.analyzer.getByteFrequencyData(frequencyArray);
            for (let i = 0; i < this.analyzer.frequencyBinCount; i++) {
                let adjustedLength = Math.floor(frequencyArray[i]) - (Math.floor(frequencyArray[i]) % 5);
                this.paths[i].setAttribute('d', 'M ' + (i) + ',255 l 0,-' + adjustedLength);
            }
        } else {
            for (let i = 0; i < 255; i++) {
                this.paths[i].setAttribute('d', 'M ' + (i) + ',255 l 0,-' + 0);
            }
        }
    }
}