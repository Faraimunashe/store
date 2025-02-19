<template>
    <vue3-snackbar top right :duration="4000"></vue3-snackbar>
    <Head title="Add Tracking Information" />
    <div class="bg-gray-50 py-12 px-6 mt-16 mb-20">
        <div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg border border-gray-200">
            <h2 class="text-3xl font-bold text-gray-800 mb-6">Add Tracking Information</h2>

            <form @submit.prevent="submitForm">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-gray-700">Carrier</label>
                        <select v-model="form.carrier" class="w-full px-4 py-2 border rounded-lg mt-1" required>
                            <option value="FeDex">FeDex</option>
                            <option value="DHL">DHL</option>
                            <option value="SWIFT">SWIFT</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700">Contact</label>
                        <input type="text" v-model="form.contact" class="w-full px-4 py-2 border rounded-lg mt-1" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div>
                        <label class="block text-gray-700">Status</label>
                        <select v-model="form.status" class="w-full px-4 py-2 border rounded-lg mt-1" required>
                            <option value="PENDING">PENDING</option>
                            <option value="PROCESSING">PROCESSING</option>
                            <option value="DISPATCHED">DISPATCHED</option>
                            <option value="DELIVERED">DELIVERED</option>
                            <option value="CANCELLED">CANCELLED</option>
                            <option value="RETURNED">RETURNED</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700">Expected Delivery Date</label>
                        <input type="date" v-model="form.expected_delivery_date" class="w-full px-4 py-2 border rounded-lg mt-1" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                    <div>
                        <label class="block text-gray-700">Expected Delivery Time</label>
                        <input type="time" v-model="form.expected_delivery_time" class="w-full px-4 py-2 border rounded-lg mt-1" required>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="block text-gray-700">Remarks (Optional)</label>
                    <textarea v-model="form.remarks" class="w-full px-4 py-2 border rounded-lg mt-1"></textarea>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Save Tracking Info</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import Layout from "../../Shared/Layout.vue";
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import { useSnackbar } from 'vue3-snackbar';

export default {
    layout: Layout,
    props: {
        order: Object
    },
    setup(props) {
        const form = useForm({
            order_id: props.order.id,
            carrier: '',
            contact: '',
            status: '',
            remarks: '',
            expected_delivery_date: '',
            expected_delivery_time: ''
        });

        const snackbar = useSnackbar();

        const resetForm = () => {
            form.reset();
        };

        const submitForm = () => {
            form.post('/adminorders', {
                onFinish: () => {
                    if (form.wasSuccessful) {
                        snackbar.add({
                            type: 'success',
                            text: 'Tracking updated successfully'
                        });
                        resetForm();
                    }
                }
            });
        };

        watch(() => form.errors.error, (error) => {
            if (error) {
                snackbar.add({
                    type: 'error',
                    text: error
                });
            }
        });

        return { form, submitForm };
    }
};
</script>
