<template>
    <qrcode-stream @detect="onDetect"></qrcode-stream>
</template>

<script>
import { QrcodeStream } from "vue-qrcode-reader";

export default {
    name: 'App',
    created() {

    },
    components: {
        QrcodeStream,
    },
    methods: {
        onDetect(detectedCodes) {
            console.log(detectedCodes);
        }
    }
}
</script>
