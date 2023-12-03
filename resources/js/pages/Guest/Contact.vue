<script setup lang="ts">
import { reactive } from "vue";

const email = reactive({ subject: null, body: null });

const handleVisitProfile = () => {
    window.open("https://amlxv.com", "_blank");
};

const handleSendEmail = () => {
    const subject = encodeURI(email.subject.toString());
    const body = encodeURI(email.body.toString());
    const template = `mailto:support@amlxv.com?subject=${subject}&body=${body}`;
    window.open(template);
};
</script>

<template>
    <div
        id="contact"
        class="mx-auto flex min-h-screen max-w-7xl flex-col justify-center px-6 lg:px-8"
    >
        <div class="relative isolate bg-white px-6 py-24 sm:py-32 lg:px-8">
            <svg
                class="absolute inset-0 -z-10 h-full w-full stroke-gray-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]"
                aria-hidden="true"
            >
                <defs>
                    <pattern
                        id="83fd4e5a-9d52-42fc-97b6-718e5d7ee527"
                        width="200"
                        height="200"
                        x="50%"
                        y="-64"
                        patternUnits="userSpaceOnUse"
                    >
                        <path d="M100 200V.5M.5 .5H200" fill="none" />
                    </pattern>
                </defs>
                <svg x="50%" y="-64" class="overflow-visible fill-gray-50">
                    <path
                        d="M-100.5 0h201v201h-201Z M699.5 0h201v201h-201Z M499.5 400h201v201h-201Z M299.5 800h201v201h-201Z"
                        stroke-width="0"
                    />
                </svg>
                <rect
                    width="100%"
                    height="100%"
                    stroke-width="0"
                    fill="url(#83fd4e5a-9d52-42fc-97b6-718e5d7ee527)"
                />
            </svg>
            <div class="mx-auto max-w-xl lg:max-w-4xl">
                <h2 class="text-4xl font-bold tracking-tight text-gray-900">
                    Let’s talk
                </h2>
                <p class="mt-2 text-lg leading-8 text-gray-600">
                    Want to share ideas to improve the system? We welcome user
                    feedback and suggestions to make this tool even better.
                </p>
                <div class="mt-16 flex flex-col gap-16 sm:gap-y-20 lg:flex-row">
                    <form
                        method="post"
                        class="lg:flex-auto"
                        @submit.prevent="handleSendEmail"
                    >
                        <div
                            class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2"
                        >
                            <div class="sm:col-span-2">
                                <label
                                    for="subject"
                                    class="block text-sm font-semibold leading-6 text-gray-900"
                                    >Subject</label
                                >
                                <div class="mt-2.5">
                                    <input
                                        required
                                        type="text"
                                        v-model="email.subject"
                                        name="subject"
                                        id="subject"
                                        autocomplete="subject"
                                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        placeholder="Donation from Tesla, Inc."
                                    />
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label
                                    for="body"
                                    class="block text-sm font-semibold leading-6 text-gray-900"
                                    >Message</label
                                >
                                <div class="mt-2.5">
                                    <textarea
                                        required
                                        v-model="email.body"
                                        id="body"
                                        name="body"
                                        rows="8"
                                        class="block w-full rounded-md border-0 px-3.5 py-2 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                        placeholder="We sincerely appreciate your idea and this effort, so we've donated $1.3 million to help you keep it going."
                                    />
                                </div>
                            </div>
                        </div>
                        <div class="mt-10">
                            <button
                                type="submit"
                                class="block w-full rounded-md bg-indigo-600 px-3.5 py-2.5 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600"
                            >
                                Let’s talk
                            </button>
                        </div>
                        <p class="mt-4 text-sm leading-6 text-gray-500">
                            You will be redirected to your
                            <a
                                href="mailto:support@amlxv.com"
                                class="font-semibold text-indigo-600"
                                >mailbox</a
                            >.
                        </p>
                    </form>
                    <div class="lg:mt-6 lg:w-80 lg:flex-none">
                        <img
                            class="h-12 w-auto"
                            src="@images/logo-b.png"
                            alt=""
                        />
                        <figure class="mt-10">
                            <blockquote
                                class="text-lg font-semibold leading-8 text-gray-900"
                            >
                                <p>
                                    “Technology is a tool we can use to improve
                                    our lives and build a better future.”
                                </p>
                            </blockquote>
                            <figcaption
                                class="mt-10 flex cursor-pointer gap-x-6 transition-all hover:scale-95"
                                @click="handleVisitProfile"
                            >
                                <img
                                    src="https://avatars.githubusercontent.com/u/34534953?v=4"
                                    alt=""
                                    class="h-12 w-12 flex-none rounded-full bg-gray-50"
                                />
                                <div>
                                    <div
                                        class="text-base font-semibold text-gray-900"
                                    >
                                        Amirul
                                    </div>
                                    <div
                                        class="text-sm leading-6 text-gray-600"
                                    >
                                        Founder of StudyMate
                                    </div>
                                </div>
                            </figcaption>
                        </figure>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
