<script setup>
  import { watch, onMounted, ref, inject, computed } from 'vue';
  import { router, useForm, usePage } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import AppTextarea from '@/components/AppTextarea.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppSpinner from '@/components/AppSpinner.vue';
  import AppValidationErrors from '@/components/AppValidationErrors.vue';
  import { useMomentJS } from '@/composables/momentjs';
  import { ScrollArea } from '../ui/scroll-area';

  const props = defineProps({
    thread: {
      type: Object,
      default: () => {},
    },
    scrollContainer: {
      type: String,
      default: '#projectFooterPopoverContentWrapper',
    },
  });

  const showForm = ref(false);
  const replyTo = ref(null);
  const editing = ref(null);

  const threadData = computed(() => (!_.isEmpty(props.thread) ? props.thread : usePage().props.model?.project?.thread));

  const $scrollTo = inject('$scrollTo');

  const form = useForm({
    body: '',
    parent_id: '',
  });

  const emit = defineEmits(['close', 'toggle-close']);

  const messages = ref(
    !_.isEmpty(props.thread) ? props.thread.messages : usePage().props.model?.project?.thread.messages,
  );

  const { dateFormat } = useMomentJS();

  const lastMessage = computed(() => _.last(messages.value));

  const handleEdit = (message) => {
    if (!message.is_owner) {
      return;
    }

    form.reset();
    replyTo.value = null;

    form.body = message.body;
    editing.value = message;

    showCreateForm();
  };

  const handleReply = (message) => {
    form.reset();
    editing.value = null;

    form.parent_id = message.id;
    replyTo.value = message;

    showCreateForm();
  };

  const confirmDelete = (message) => {
    if (!window.confirm('Are you sure you want to delete message?')) {
      return;
    }

    const lastScrollIndex = _.findIndex(messages.value, (m) => m.id == message.id);

    const scrollMessage = messages.value[lastScrollIndex];

    router.delete(
      route('restore.threads.messages.destroy', {
        thread: threadData.value,
        message: message,
      }),
      {
        onSuccess: () => {
          resetMessages();

          if (messages.value.length > 1 && messages.value.length >= lastScrollIndex) {
            scrollToMessage(scrollMessage);
          }
        },
      },
    );
  };

  const toggleCreateForm = () => {
    showForm.value = !showForm.value;
  };

  const showCreateForm = () => {
    showForm.value = true;
  };

  const hideCreateForm = () => {
    showForm.value = false;
  };

  const resetMessages = () => {
    messages.value = !_.isEmpty(props.thread) ? props.thread.messages : usePage().props.model?.project?.thread.messages;
  };

  const scrollToEl = (el) => {
    $scrollTo(el, {
      container: props.scrollContainer,
      duration: 500,
    });
  };

  const scrollToMessage = (message) => {
    scrollToEl(`#messageWrapperRef${message.id}`);
  };

  const store = async () => {
    if (editing.value) {
      const message = editing.value;

      form.patch(
        route('restore.threads.messages.update', {
          thread: threadData.value,
          message: editing.value,
        }),
        {
          onSuccess: () => {
            resetMessages();
            hideCreateForm();
            form.reset();

            setTimeout(() => {
              if (messages.value.length > 1) {
                scrollToMessage(message);
              }
            }, 1500);
          },
        },
      );
      return;
    }

    form.post(
      route('restore.threads.messages.store', {
        thread: threadData.value,
      }),
      {
        onSuccess: () => {
          form.reset();
          resetMessages();
          hideCreateForm();

          setTimeout(() => {
            if (messages.value.length > 1) {
              scrollToMessage(lastMessage.value);
            }
          }, 1500);
        },
      },
    );
  };

  onMounted(() => {
    watch(
      () => form.processing,
      () => {
        emit('toggle-close');
      },
    );

    watch(showForm, (val) => {
      if (val == false) {
        editing.value = null;
        replyTo.value = null;
        form.reset();

        setTimeout(() => {
          scrollToMessage(lastMessage.value);
        }, 500);
      } else {
        setTimeout(() => {
          scrollToEl('#projectNotesEditorForm');
          document.getElementById('#projectNotesEditorTextareaRef')?.focus();
        }, 500);
      }
    });

    if (messages.value.length > 1) {
      scrollToMessage(lastMessage.value);
    }
  });
</script>

<template>
  <div
    id="messageWrapperContainer"
    class="flex flex-col px-4 pt-4 pb-12 space-y-4"
  >
    <div
      v-if="!showForm"
      class="flex items-center justify-between mb-6 text-sm text-slate-600 font-medium"
    >
      <p v-if="messages.length < 1">{{ __('tenant.project.no_message_found') }}</p>

      <a
        href="#"
        :class="{ 'ml-auto': messages.length > 0 }"
        class="px-2 py-2 rounded-md text-indigo-600 hover:bg-indigo-200 transition ease-in-out duration-200"
        @click.prevent="toggleCreateForm"
        >{{
          showForm
            ? __('app.buttons.cancel')
            : messages.length
              ? __('tenant.labels.new_message')
              : __('tenant.labels.start_conversation')
        }}</a
      >
    </div>

    <!-- Messages Wrapper -->
    <div class="container mx-auto flex flex-col gap-4">
      <!-- Message -->
      <div
        v-for="message in messages"
        :id="`messageWrapperRef${message.id}`"
        :key="message.id"
        :class="[
          message.user.id === $page.props.auth.user.id ? 'self-end rounded-tr-none bg-lime-100' : 'rounded-tl-none',
        ]"
        class="min-w-[2rem] sm:max-w-md lg:max-w-2xl px-4 py-2 md:py-1 space-y-3 rounded-md bg-slate-100 dark:bg-slate-800"
      >
        <!-- User -->
        <div class="flex items-center flex-wrap gap-1 text-xs">
          <a
            href="#"
            class="text-xs font-medium text-blue-500 hover:text-blue-600"
            @click.prevent
          >
            {{ message?.user.name }}
          </a>

          <span>&bullet;</span>

          <!-- Time -->
          <span class="text-slate-500 dark:text-indigo-200">
            <span v-if="message.edited_at">({{ __('tenant.labels.edited') }})</span>
            {{ dateFormat(message.created_at, 'MMM Do, YYYY HH:mm') }}
          </span>
          <!-- END Time -->
        </div>
        <!-- END User -->

        <!-- Reply -->
        <div v-if="message.parent">
          <AppInputLabel class="block">Reply to {{ message.parent.user?.name }}</AppInputLabel>

          <div
            v-scroll-to="{
              el: `#messageWrapperRef${message.parent.id}`,
              container: scrollContainer,
              duration: 500,
            }"
            class="px-4 py-2 mt-3 mb-6 rounded-md cursor-pointer text-slate-700 prose prose-sm lg:prose truncate bg-slate-200 hover:bg-opacity-60"
            v-html="message.parent.body"
          ></div>
        </div>
        <!-- END Reply -->

        <!-- Body -->
        <div
          class="text-slate-700 dark:text-slate-100 prose prose-sm lg:prose"
          v-html="message.body"
        ></div>
        <!-- END Body -->

        <!-- Meta -->
        <div class="flex items-center justify-end gap-3 text-sm">
          <!-- Actions -->
          <div class="flex items-center justify-end gap-3">
            <!-- Edit -->
            <a
              v-if="message.is_owner"
              href="#"
              class="px-2 py-2 font-medium text-sm text-blue-600 hover:underline"
              @click.prevent="handleEdit(message)"
              >Edit</a
            >
            <!-- END Edit -->

            <!-- Reply -->
            <a
              href="#"
              class="px-2 py-2 font-medium text-sm text-indigo-600 hover:underline"
              @click.prevent="handleReply(message)"
              >Reply</a
            >
            <!-- END Reply -->

            <!-- Delete -->
            <a
              v-if="message.is_owner"
              href="#"
              class="px-2 py-2 font-medium text-sm text-red-600 hover:underline"
              @click.prevent="confirmDelete(message)"
              >Delete</a
            >
            <!-- END Delete -->
          </div>
          <!-- END Actions -->
        </div>
        <!-- END Meta -->
      </div>
      <!-- END Message -->

      <!-- New Message Button -->
      <div
        v-if="messages.length > 1"
        class="flex items-center justify-end mt-6"
      >
        <a
          v-if="!showForm"
          href="#"
          class="px-2 py-2 rounded-md text-indigo-600 hover:bg-indigo-200 transition ease-in-out duration-200"
          @click.prevent="toggleCreateForm"
          >{{ __('tenant.labels.new_message') }}</a
        >
      </div>
      <!-- New Message Button -->
    </div>
    <!-- END Messages Wrapper -->

    <div
      v-if="showForm && messages.length > 0"
      class="h-2 mt-2 border-t-2 border-indigo-200 dark:border-indigo-400"
    ></div>

    <!-- Create/Reply/Edit Form -->
    <form
      v-if="showForm"
      id="projectNotesEditorForm"
      method="post"
      class="mt-auto"
      @submit.prevent="store"
    >
      <AppValidationErrors
        v-if="form.hasErrors"
        :errors="form.errors"
        class="mb-4"
      />

      <div>
        <AppInputLabel>{{
          editing?.id
            ? __('app.labels.editing')
            : replyTo?.id
              ? __('tenant.labels.replying_to')
              : __('tenant.labels.new_note')
        }}</AppInputLabel>

        <div
          v-if="replyTo"
          v-scroll-to="{
            el: `#messageWrapperRef${replyTo.id}`,
            container: scrollContainer,
            duration: 500,
          }"
          class="px-2 py-2 mt-2 mb-6 space-y-2 rounded bg-slate-100 shadow-sm drop-shadow-sm shadow-indigo-200"
        >
          <p class="text-xs font-semibold">{{ replyTo?.user?.name }}</p>

          <div
            class="py-1 rounded-md text-slate-700 prose prose-sm lg:prose truncate"
            v-html="replyTo.body"
          ></div>
        </div>
      </div>

      <!-- Body -->
      <div class="mt-4">
        <AppTextarea
          id="projectNotesEditorTextareaRef"
          v-model="form.body"
          class="w-full"
        />

        <AppInputError
          class="mt-2"
          :message="form.errors.body"
        />
      </div>
      <!-- END Body -->

      <!-- Buttons -->
      <div class="flex items-center justify-end gap-3 mt-4">
        <!-- Cancel Button -->
        <a
          href="#"
          class="px-2 py-2 rounded-md uppercase font-semibold text-sm text-indigo-600 hover:bg-indigo-200 transition ease-in-out duration-200 focus:outline-none focus:ring ring-indigo-200"
          @click.prevent="toggleCreateForm"
          >{{ __('app.buttons.cancel') }}</a
        >
        <!-- END Cancel Button -->

        <!-- Submit Button -->
        <AppButton
          type="submit"
          class="inline-flex items-center gap-2"
          :disabled="form.processing"
        >
          <AppSpinner
            v-if="form.processing"
            :size="4"
          />
          {{ __('tenant.labels.post_message') }}
        </AppButton>
        <!-- END Submit Button -->
      </div>
      <!-- END Buttons -->
    </form>
    <!-- END Create/Reply/Edit Form -->
  </div>
</template>
