<script setup lang="ts">
import _ from "lodash";
import moment from "moment/moment";
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";
import { Line } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    CategoryScale,
    LinearScale,
    LineElement,
    LineController,
    PointElement,
    Filler,
} from "chart.js";

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    CategoryScale,
    LinearScale,
    LineElement,
    LineController,
    PointElement,
    Filler,
);

const page = usePage();
const props = page?.props;

const months = _.map(moment.monthsShort(), (month) => _.toLower(month));

const chartData = ref({
    labels: moment.monthsShort(),
    datasets: [
        {
            label: "Class",
            data: _.map(
                months,
                (month) => props?.schedulesStatistics?.classes[month],
            ),
            fill: true,
            backgroundColor: "rgba(54, 162, 235, 0.1)",
            borderColor: "rgba(54, 162, 235, 0.8)",
            pointBackgroundColor: "rgba(75, 192, 192, 0.8)",
        },
        {
            label: "Activity",
            data: _.map(
                months,
                (month) => props?.schedulesStatistics?.activities[month],
            ),
            fill: true,
            backgroundColor: "rgba(255, 99, 132, 0.1)",
            borderColor: "rgba(255, 99, 132, 0.8)",
            pointBackgroundColor: "rgba(67, 56, 202, 0.8)",
        },
        {
            label: "Class (Remind)",
            data: _.map(
                months,
                (month) => props?.schedulesStatistics?.classesRemind[month],
            ),
            fill: true,
            backgroundColor: "rgba(14, 162, 135, 0.1)",
            borderColor: "rgba(14, 162, 135, 0.8)",
            pointBackgroundColor: "rgba(14, 162, 135, 0.8)",
        },
        {
            label: "Activity (Remind)",
            data: _.map(
                months,
                (month) => props?.schedulesStatistics?.activitiesRemind[month],
            ),
            fill: true,
            backgroundColor: "rgba(0, 99, 132, 0.1)",
            borderColor: "rgba(0, 10, 110, 0.8)",
            pointBackgroundColor: "rgba(0, 99, 132, 0.8)",
        },
    ],
});

const chartOptions = {
    responsive: true,
};
</script>

<template>
    <Line id="global_statistics" :data="chartData" :options="chartOptions" />
</template>
