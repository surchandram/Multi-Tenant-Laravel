import { router, usePage } from '@inertiajs/vue3';
import { useToast } from 'vue-toastification';
import useNotice from '@/composables/useNotice';

const notice = useNotice();

const toast = useToast();

export const notifications = () => {
    router.on('finish', () => {
        const notification = usePage().props.notification;

        if (notification.type == 'notice') {
            notice.show(notification.body);
            return;
        }

        if (notification.type && notification.body) {
            toast(notification.body, {
                type: notification.type,
            });
        }
    });
};
