

class AudioVisualizer {
    constructor(visualizer, audioContent, stream, amountOfDataPoints) {
        this.visualizer = visualizer;
        visualizer.setAttribute('viewBox', `0 0 ${amountOfDataPoints} 255`);
        this.running = false;
        this.audioStream = audioContent.createMediaStreamSource(stream);
        this.analyzer = audioContent.createAnalyser();
        this.analyzer.fftSize = 1024;
        this.audioStream.connect(this.analyzer);
        this.paths = [];
        this.amountOfDataPoints = amountOfDataPoints;
        let mask = this.visualizer.getElementById('mask');
        for (let i = 0; i < this.amountOfDataPoints; i++) {
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
            let amountOfDataPoints = this.analyzer.frequencyBinCount;
            let frequencyArray = new Uint8Array(amountOfDataPoints);
            this.analyzer.getByteFrequencyData(frequencyArray);
            let audioSignalPerXPoints = Math.floor(amountOfDataPoints / this.amountOfDataPoints);
            for (let i = 0; i < this.amountOfDataPoints; i++) {
                let averageSignalPoint = 0;
                for (let c = 0; c < audioSignalPerXPoints; c++) {
                    averageSignalPoint += frequencyArray[i+c];
                }
                averageSignalPoint = averageSignalPoint / audioSignalPerXPoints;
                let adjustedLength = Math.floor(frequencyArray[i]) - (Math.floor(frequencyArray[i]) % 5);
                this.paths[i].setAttribute('d', 'M ' + (i) + ',255 l 0,-' + adjustedLength);
            }
            requestAnimationFrame(() => {
                this.doDraw();
            });
        } else {
            for (let i = 0; i < this.amountOfDataPoints; i++) {
                this.paths[i].setAttribute('d', 'M ' + (i) + ',255 l 0,-' + 0);
            }
        }
    }
}