import Create from './pages/Create.vue';
import Edit from './pages/Edit.vue';

export const NoteRoutes =  [
    { path: '/notes/create', component: Create, name: 'note.create' },
    { path: '/notes/:id/edit', component: Edit, name: 'note.edit' },
];