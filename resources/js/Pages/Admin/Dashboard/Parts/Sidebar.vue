<template>
    <div :class="[{close: props.close}, 'sidebar']">

        <Link class="brand-box" v-if="!noLogo" href="#">
           <img :src="props.logo?.img ?? '/logo-placeholder2.png'" height="35" alt="">
           <span v-if="props.logo?.name" class="logo-text">{{ props.logo.name }}</span>
        </Link>

        <div class="sidebar-content">
          <div class="avatar-box" v-if="!props.noAvatar">
            <div class="avatar-img" :style="`background-image: url('/${props.avatar?.img ?? 'cat.jpg'}')`"></div>
            <Link class="avatar-name" href="#">{{ props.avatar?.name ?? 'Anonymous Catto' }}</Link>
          </div>

          <div class="search-box" v-if="!noSearch">
            <input type="text" >
            <ButtonIcon :icon="{ name: 'magnifying-glass'}" square style="border: 1px solid #ff7575; border-left: none; border-radius: 0px 3px 3px 0px;" />
          </div>

          <div v-for="navigation in navigations">
            <SidebarButton 
              v-if="navigation.dropdown" :active="$page.url.startsWith(navigation.prefix ?? '')" 
              :menuLinks="navigation.menuLinks" :label="navigation.label" :icon="{ name: navigation.icon ?? '' }" 
              :fontType="navigation.fontType" dropdown :prefix="navigation.prefix"
            />

            <SidebarButton 
              v-else-if="navigation.button" :active="$page.url == navigation.link" :link="navigation.link"
              :label="navigation.label" :icon="{ name: navigation.icon ?? '' }"  :fontType="navigation.fontType" 
            />

            <h4 v-else class="sidebar-label">{{ navigation.label }}</h4> 
          </div>

          <Link
              class="sidebar-label"
              href="/logout" method="post"
          >
            <button class="logout-btn" >Logout</button>
          </Link>

        </div>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import ButtonIcon from '@/Components/Button.vue';
import SidebarButton from './SidebarButton.vue';
import { Avatar, Logo, Navigations } from '@/Utilities/Interfaces'
// import SidebarDropdown from './Parts/SidebarDropdown.vue';


interface Sidebar{
  close?: boolean,
  noLogo?: boolean,
  noAvatar?: boolean,
  noSearch?: boolean,

  avatar?: Avatar,
  logo?: Logo,

  navigations?: Navigations[]
}

const props = withDefaults( defineProps<Sidebar>(), {
  close: false,
  noLogo: false,
  noAvatar: false,
  noSearch: false,
})
</script>

<style lang="scss" scoped>
  $border-color: #ff7575;


.sidebar{
  width: 100%;
  max-width: 250px;
  height: 100vh;
  background-color: $red;
  transition: .25s ease-out;
  overflow: hidden;

  .brand-box, .avatar-box{
    @include sidebarBox(150px);
  }
  .logo-text, .avatar-name{
    @include sidebarText();
  }

  .sidebar-label{
    color: rgb(255, 218, 218);
    margin-bottom: .5rem;
  }
  .brand-box{
    text-decoration: none;
    padding: 13px 1rem 13px 1rem;
    color: white !important;

    .logo-text{
      margin-left: .75rem;
    }
  }

  .sidebar-content{
    flex: 1;
    transition: all .35s ease;
    overflow-x: hidden;
    overflow-y: auto;
    max-height: 100%;
    scrollbar-gutter: stable both-edges;

    .logout-btn{
      border: none;
      outline: none;
      margin-top: 3rem;
      padding: .15rem .5rem .15rem .5rem;
      background-color: transparent;
      cursor: pointer;
      color: #ffc4c4;
      font-weight: bold;
      font-size: 18px;
      transition: .25s ease;

      &:hover{
        color: white;
        text-decoration: underline;
      }
    }

    .search-box{
      border-radius: 3px;
      display: flex;
      margin-top: 1.25rem;
      margin-bottom: .75rem;

      input[type=text]{
        flex: 1;
        padding: 5px 9px 5px 9px;
        border: $border-color 1px solid;
        border-radius: 3px 0px 0px 3px;
        outline: none;
        background-color: rgba($color: $border-color, $alpha: .250);
        font-weight: bold;
        color: white;

        &:hover, &:focus{
          border: $border-color 1px solid;
        }
      }
    }

    /* width */
    &::-webkit-scrollbar {
      width: 7.5px;
    }
    /* Handle */
    &::-webkit-scrollbar-thumb {
      transition: all .35s ease;
      background-color: inherit;
      border-right: 2px solid $red;
      border-radius: 3px;
    }
    /* Handle on hover */
    &::-webkit-scrollbar-thumb:hover {
      background: #ffc4c4 !important;
    }

    &:hover::-webkit-scrollbar-thumb{
      background-color: #ff6b6b;
    }
  }

  .avatar-box{
    width: 100%;
    padding: 13px 1rem 13px .5rem;
    .avatar-img{
      width: 35px;
      height: 35px;
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      border-radius: 100%;
    }
    .avatar-name{
      color: rgb(255, 218, 218);
      font-size: 14px;
      margin: 0px;
      margin-left: .75rem;
      text-decoration: none;

      &:hover{
        color: white;
      }
    }
  }

}

.close{
  max-width: 65px !important;

  &:hover, &:focus{
    max-width: 250px !important;
    & :is(.logo-text, .avatar-name, .btn-label){
      opacity: 1 !important;
    }

    & :is(.search-box, .sidebar-label){
      display: flex !important;
    }

    & :is(.sidebar-btn, .dropdown-btn, .dropdown-link){
      padding: .65rem 1.35rem .65rem 1.35rem !important;
    }
  }
  
  & :is(.logo-text, .avatar-name, .btn-label){
    opacity: 0 !important;
  }

  & :is(.search-box, .sidebar-label){
    display: none !important;
  }

  & :is(.sidebar-btn, .dropdown-btn, .dropdown-link){
    padding: .65rem .5rem .65rem 1.1rem !important;
  }
}

@media screen and (min-width: 934px) {
  .sidebar{
    max-width: 250px;
  }
}
@media screen and (min-width: 0px) and (max-width: 933px) {
  .sidebar{
    max-width: 0px;
    width: 0px;
    top: 0px;
    left: 0px;
    position: fixed;
    box-shadow: 0rem .5rem .5rem rgba($color: #000000, $alpha: .50);
    z-index: 99;
  }

  .close{
    max-width: 250px !important;
    width: 250px;
    
    & :is(.logo-text, .avatar-name, .btn-label){
      opacity: 1 !important;
    }

    & :is(.search-box, .sidebar-label){
      display: flex !important;
    }

    & :is(.sidebar-btn, .dropdown-btn, .dropdown-link){
      padding: .65rem .5rem .65rem 1.1rem !important;
    }
  }
}

</style>