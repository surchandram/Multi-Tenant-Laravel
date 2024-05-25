<script setup>
  import { inject, onMounted, ref } from 'vue';
  import { Html5QrcodeScanner } from 'html5-qrcode';

  const props = defineProps({
    modelValue: {
      type: [String, Number, Boolean, Object],
      default: '',
    },
    qrbox: {
      type: Number,
      default: 250,
    },
    fps: {
      type: Number,
      default: 10,
    },
    qrConfig: {
      type: Object,
      default: () => {},
    },
    id: {
      type: String,
      default: 'qr-code-full-region',
    },
  });

  const $eventBus = inject('$eventBus');

  const emit = defineEmits(['qrcode-scanner::result', 'qrcode-scanner::stopped']);

  const html5QrcodeScanner = ref(null);

  const onScanSuccess = (decodedText, decodedResult) => {
    emit('qrcode-scanner::result', {
      decodedText,
      decodedResult,
    });

    $eventBus.emit('qrcode-scanner::result', {
      decodedText,
      decodedResult,
    });

    stopScanning();
  };

  const stopScanning = () => {
    if (!html5QrcodeScanner.value) {
      return;
    }

    document.getElementById('html5-qrcode-button-camera-stop')?.click();

    emit('qrcode-scanner::stopped', props.id);
    $eventBus.emit('qrcode-scanner::stopped', props.id);
  };

  onMounted(() => {
    var config = {
      fps: props.fps,
      qrbox: props.qrbox,
    };

    html5QrcodeScanner.value = new Html5QrcodeScanner(props.id, config);
    html5QrcodeScanner.value.render(onScanSuccess);

    $eventBus.on('qrcode-scanner::scan', () => {
      html5QrcodeScanner.value.render(onScanSuccess);
    });

    $eventBus.on('qrcode-scanner::stop', () => {
      stopScanning();
    });
  });
</script>

<template>
  <div :id="id"></div>
</template>
