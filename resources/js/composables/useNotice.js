import { ref } from 'vue';

const open = ref(false);
const notice = ref();

export default () => {
    const show = (data = {}) => {
        notice.value = data;

        setTimeout(() => {
            open.value = true;
        }, 200);
    };

    const close = () => {
        open.value = false;
        notice.value = null;
    };

    return {
        open,
        notice,
        show,
        close,
    };
};
