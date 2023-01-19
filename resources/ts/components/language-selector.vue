<template>
    <el-tooltip effect="light">
        <template #content>
            <div class="language-options">
                <el-button @click="changeLanguage(language.value)" v-for="language in languages.available.filter((language) => language.value !== locale)" class="language-button">
                    <img :src="getLanguageFlag(language.value)"/>
                    <span>{{ language.flag }}</span>
                </el-button>
            </div>
        </template>
        <el-button replace href="" class="language-button">
            <img :src="getLanguageFlag(locale)"/>
            <span>{{  locale.toUpperCase()  }}</span>
        </el-button>
    </el-tooltip>
</template>

<script lang="ts" setup>
import RoFlagImg from "@/assets/images/ro.png";
import EnFlagImg from "@/assets/images/gb.png";
import { Inertia } from "@inertiajs/inertia";
import {usePage, Link} from "@inertiajs/inertia-vue3";
const locale = usePage().props.value.locale;
const languages : any = usePage().props.value.languages;
const changeLanguage = (locale : string) => {
    Inertia.post(route('language', {language: locale}), null, {
        onSuccess: () => {
            location.reload();
        }
    })
};
const getLanguageFlag = (locale: string) => {
    switch (locale) {
        case 'en':
            return EnFlagImg;
            break;
        case 'ro':
            return RoFlagImg;
            break;
    }
};
</script>

<style lang="css">
.language-switcher {
    margin-right: 2rem;
}
.language-button {
    text-decoration: none;
    color: #333;
    font-size: .7rem;
    display: flex;
    align-items: center;
}
.language-button img {
    margin-right: .5rem;
}
.language-options {
    display: flex;
    flex-direction: column;
}
.language-button {
    border: none;
}
.language-button:hover {
    background-color: transparent;
}
</style>
