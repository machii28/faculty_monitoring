<template>
    <qrcode-stream @detect="onDetect" :paused="paused" :track="this.paintOutline">
        <div v-show="showScanConfirmation" class="scan-confirmation">
            {{ message }}
        </div>
    </qrcode-stream>
</template>

<script>
import {QrcodeStream} from "vue-qrcode-reader";

export default {
    name: 'App',
    data() {
        return {
            trackOption: 'outline',
            paused: false,
            result: null,
            showScanConfirmation: false,
            message: ''
        };
    },
    created() {

    },
    components: {
        QrcodeStream,
    },
    methods: {
        async onDetect([firstDetectedCode]) {
            this.result = firstDetectedCode.rawValue;

            this.showScanConfirmation = true;
            this.paused = true;

            await this.bundy(this.result);
            await this.timeout(2000);

            this.paused = false;
            this.showScanConfirmation = false;
        },

        timeout(ms) {
            return new Promise((resolve) => {
                window.setTimeout(resolve, ms)
            })
        },

        paintOutline(detectedCodes, ctx) {
            for (const detectedCode of detectedCodes) {
                const [firstPoint, ...otherPoints] = detectedCode.cornerPoints

                ctx.strokeStyle = 'red'

                ctx.beginPath()
                ctx.moveTo(firstPoint.x, firstPoint.y)
                for (const {x, y} of otherPoints) {
                    ctx.lineTo(x, y)
                }
                ctx.lineTo(firstPoint.x, firstPoint.y)
                ctx.closePath()
                ctx.stroke()
            }
        },

        async bundy(roomId) {
            try {
                await axios.get(`/${roomId}/bundy`).then((response) => {
                    this.message = response.data.message;
                });
            } catch (error) {
                console.error('Error calling /{roomId}/bundy:', error);
            }
        }
    }
}
</script>

<style scoped>
.scan-confirmation {
  position: absolute;
  width: 100%;
  height: 100%;

  background-color: rgba(255, 255, 255, 0.8);
  padding: 10px;
  text-align: center;
  font-weight: bold;
  font-size: 1.4rem;
  color: green;

  display: flex;
  flex-flow: column nowrap;
  justify-content: center;
}
</style>
