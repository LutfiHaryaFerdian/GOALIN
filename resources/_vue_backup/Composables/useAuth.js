import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

export function useAuth() {
    const page = usePage();
    const user    = computed(() => page.props.auth.user);
    const isAdmin = computed(() => user.value?.role === 'admin');
    const isOwner = computed(() => user.value?.role === 'owner');
    const isUser  = computed(() => user.value?.role === 'user');
    return { user, isAdmin, isOwner, isUser };
}
