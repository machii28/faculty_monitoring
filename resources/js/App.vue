<template>
    <qrcode-stream @detect="onDetect" :paused="paused" :track="this.paintOutline">
        <div v-show="showScanConfirmation" class="scan-confirmation">
            {{ message }}
        </div>
    </qrcode-stream>

    <!-- Modal -->
    <div class="fixed z-10 inset-0 overflow-y-auto" :class="{ 'hidden': !showModal }">
        <div class="flex items-center justify-center min-h-screen">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="showModal = false"></div>

            <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <!-- Modal content -->
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">
                            Select Subject Code
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                <select v-model="selectedSubject"
                                        class="block w-full bg-white border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                    <option value="">Select a subject...</option>
                                    <option v-for="subject in subjects" :key="subject.id" :value="subject.code">
                                        {{ subject.name }}
                                    </option>
                                </select>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" @click="passBundy()"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-gray-800 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Submit
                    </button>

                    <button type="button" @click="showModal = false"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
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
            message: '',
            showModal: false,
            subjects: [],
            selectedSubject: '',
        };
    },
    created() {
        this.fetchSubjects();
    },
    components: {
        QrcodeStream,
    },
    methods: {
        fetchSubjects() {
            axios.get(`/subjects`).then((response) => {
                this.subjects = response.data;
            });
        },

        passBundy() {
            this.bundy(this.result, this.selectedSubject);
        },

        closeModal() {
            this.showModal = false;
        },

        async onDetect([firstDetectedCode]) {
            this.result = firstDetectedCode.rawValue;

            this.showScanConfirmation = true;
            this.paused = true;

            //let subjectCode = window.prompt('Enter Subject Code');
            //await this.bundy(this.result, subjectCode);
            this.showModal = true; // Open the modal after the bundy function call
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

        async bundy(roomId, subjectCode) {
            try {
                await axios.get(`/${roomId}/bundy?subject=${subjectCode}`).then((response) => {
                    this.message = response.data.message;
                    this.showModal = false;
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

/* Modal styles */
.modal {
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: none;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background-color: white;
    padding: 20px;
    border-radius: 5px;
}

.is-active {
    display: flex;
}
</style>
