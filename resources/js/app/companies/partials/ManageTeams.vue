<script setup>
  import { ref, onMounted, watch, computed } from 'vue';
  import { useForm } from '@inertiajs/vue3';
  import AppButton from '@/components/AppButton.vue';
  import AppLightButton from '@/components/AppLightButton.vue';
  import AppInputLabel from '@/components/AppInputLabel.vue';
  import AppInputError from '@/components/AppInputError.vue';
  import AppModal from '@/components/AppModal.vue';
  import AppSpinner from '@/components/AppSpinner.vue';
  import TeamCreator from '@/components/teams/TeamCreator.vue';
  import Team from '@/components/teams/Team.vue';

  const props = defineProps({
    company: {
      required: true,
      type: Object,
    },
    teams: {
      type: Array,
      default: () => [],
    },
  });

  const showForm = ref(false);
  const editing = ref(null);
  const editingId = ref(null);

  const edit = (team) => {
    editing.value = team;
    editingId.value = team.id;
    setTimeout(() => {
      showForm.value = true;
      editingMode.value = true;
    }, 200);
  };

  const editingMode = ref(false);
  const deleteForm = useForm({});

  const addTeamMemberForm = useForm({
    team_id: '',
    user_id: '',
  });

  const addMember = (team) => {
    editing.value = team;
    addTeamMemberForm.team_id = team.id;

    // open modal
    $eventBus.emit('open-modal', 'AddTeamMemberModal');
  };

  const storeTeamMember = () => {
    addTeamMemberForm.post(route('companies.teams.users.store', props.company.id), {
      onSuccess: () => {
        addTeamMemberForm.reset();
        $eventBus.emit('close-modal', 'AddTeamMemberModal');
      },
    });
  };

  const confirmDelete = (team) => {
    if (!confirm(`Are you sure you want to delete ${team.name} from teams?`)) {
      return;
    }

    deleteForm.delete(
      route('companies.teams.destroy', {
        company: props.company,
        team: team.id,
      }),
      {},
    );
  };

  const createAction = computed(() => {
    return editingMode.value
      ? route('companies.teams.update', {
          company: props.company,
          team: editingId.value,
        })
      : route('companies.teams.store', props.company);
  });

  onMounted(() => {
    watch(showForm, (val) => {
      if (val == false && editing.value) {
        editingMode.value = false;
        editing.value = null;
        editingId.value = null;
      }
    });
  });
</script>

<template>
  <div>
    <TeamCreator
      v-if="showForm"
      v-model="editing"
      :editing="editingMode"
      :action="createAction"
      @close="showForm = false"
    >
      <template #buttons>
        <AppLightButton @click="showForm = false"> Cancel </AppLightButton>
      </template>
    </TeamCreator>

    <template v-else>
      <div class="flex items-center">
        <p class="text-sm text-slate-400">Manage different teams in your company here.</p>

        <aside class="ml-auto">
          <AppButton @click="showForm = true"> Add Team </AppButton>
        </aside>
      </div>

      <p
        v-if="props.teams.length <= 0"
        class="mt-6"
      >
        No teams found.
      </p>

      <div
        v-else
        class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6"
      >
        <Team
          v-for="team in teams"
          :key="team.id"
          :team="team"
        >
          <template #icon>
            <i class="bi bi-people text-3xl"></i>
          </template>

          <template #footer>
            <div class="w-full flex flex-wrap gap-3 mt-5">
              <AppButton @click="edit(team)"> <i class="bi bi-pencil"></i> Edit </AppButton>

              <AppButton @click="addMember(team)"> <i class="bi bi-person-plus"></i> Add Member </AppButton>

              <AppLightButton @click="confirmDelete(team)"> <i class="bi bi-trash"></i> Delete </AppLightButton>
            </div>
          </template>
        </Team>
      </div>
    </template>

    <AppModal
      id="AddTeamMemberModal"
      no-footer
    >
      <form
        action="#"
        @submit.prevent="storeTeamMember"
      >
        <h4 class="text-sm font-semibold">
          {{ __('app.labels.add_member_to_team', { team: editing.name }) }}
        </h4>

        <div class="mt-8">
          <AppInputLabel
            for="teamMemberUserId"
            value="Pick user"
          />

          <div class="w-full mt-2">
            <select
              id="teamMemberUserId"
              v-model="addTeamMemberForm.user_id"
              class="form-control w-full block"
            >
              <option value="">---</option>
              <option
                v-for="user in company.users"
                :key="user.id"
                :value="user.id"
              >
                {{ user.name }} ({{ user.email }})
              </option>
            </select>
          </div>

          <AppInputError
            class="mt-2"
            :message="addTeamMemberForm.errors.user_id"
          />
        </div>

        <div class="flex items-center justify-end mt-8">
          <AppLightButton
            type="button"
            :disabled="addTeamMemberForm.processing"
            @click.prevent="$eventBus.emit('close-modal', 'AddTeamMemberModal')"
          >
            {{ __('app.labels.close') }}
          </AppLightButton>

          <AppButton
            type="submit"
            class="inline-flex items-center gap-2"
            :disabled="addTeamMemberForm.processing"
            @click.prevent="storeTeamMember"
          >
            <AppSpinner v-if="addTeamMemberForm.processing" />
            {{ __('app.buttons.add_team_member') }}
          </AppButton>
        </div>
      </form>
    </AppModal>
  </div>
</template>
