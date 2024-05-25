import { ref } from "vue";

const visible = ref(false);

export default() => {

    const showFixedFormPopover = () => {
        visible.value = true;
    };

    const hideFixedFormPopover = () => {
        visible.value = false;
    };


    return {
        visible,
        showFixedFormPopover,
        hideFixedFormPopover,
    }
}
