<template>
    <div v-if="source.data.length || destination.data.length" class="container">
      <div class="side">
        <input
          v-model="searchLeftList"
          type="text"
          placeholder="Search..."
        />
  
        <div class="box">
          <div
            v-for="(group, index) in source.data.filter((group : IGroup) =>
              group.label.toLowerCase().includes(searchLeftList.toLowerCase())
            )"
            :key="index"
            class="content"
          >
            <span class="label" @click="selectGroup(group)">{{
              group.label
            }}</span>
            <ul class="list">
              <li
                v-for="item in group.items"
                :key="item.id"
                class="item"
                :class="item.selected ? 'selected' : ''"
                @click="selectItem(item)"
              >
                {{ item.name }}
              </li>
            </ul>
          </div>
        </div>
        <div class="tools">
          <div class="select-all" @click="selectAll(source)">Select All s</div>
          <div class="select-none" @click="selectNone(source)">None</div>
        </div>
      </div>
      <div class="middle">
        <button
          type="button"
          class="arrow-button"
          @click="transferData(source, destination)"
        >
          <svg class="arrow-right" width="24" height="24" viewBox="0 0 24 24">
            <path
              d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"
            ></path>
          </svg>
        </button>
        <button
          type="button"
          class="arrow-button"
          @click="transferData(destination, source)"
        >
          <svg class="arrow-left" width="24" height="24" viewBox="0 0 24 24">
            <path
              d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"
            ></path>
          </svg>
        </button>
      </div>
      <div class="side">
        <input v-model="searchRightList" type="text" placeholder="Search..." />
        <div class="box">
          <div
            v-for="(group, index) in destination.data.filter((group) =>
              group.label.toLowerCase().includes(searchRightList.toLowerCase())
            )"
            :key="index"
            class="content"
          >
            <span class="label" @click="selectGroup(group)">{{
              group.label
            }}</span>
            <ul class="list">
              <li
                v-for="item in group.items"
                :key="item.id"
                class="item"
                :class="item.selected ? 'selected' : ''"
                @click="selectItem(item)"
              >
                {{ item.name }}
              </li>
            </ul>
          </div>
        </div>
        <div class="tools">
          <div class="select-all" @click="selectAll(destination)">Select All</div>
          <div class="select-none" @click="selectNone(destination)">None</div>
        </div>
      </div>
    </div>
    <div v-else class="container">
      There are no permissions saved at this moment.
    </div>
  </template>
  
  <script lang="ts" setup>
    import { defineProps, defineEmits, reactive, ref } from 'vue';

    interface Iitem {
        id: number;
        name: string;
        selected: boolean | null;
    };

    interface IGroup {
        label: string,
        items: Iitem[],
    };
  
    // props
    const props = defineProps(['orgSource', 'orgDestination']);
  
    // events
    const emit = defineEmits(['onListChange']);
  
    // component data
    const source = reactive({ data: props.orgSource });
    const destination = reactive({ data: props.orgDestination });
  
    // search data for left list
    const searchLeftList = ref<string>('');
    const searchRightList = ref<string>('');
  
    // all the logic goes in these methods
    const selectItem = (item : Iitem) => {
      item.selected = true;
    };
    const selectGroup = (group : IGroup) => {
      group.items = group.items.map((item : Iitem) => {
        item.selected = true;
        return item;
      });
    };
    const selectAll = (myData : any) => {
      myData.data = myData.data.map((group : IGroup) => {
        group.items = group.items.map((item : Iitem) => {
          item.selected = true;
          return item;
        });
        return group;
      });
    };
    const selectNone = (myData : any) => {
      myData.data = myData.data.map((group : IGroup) => {
        group.items = group.items.map((item : Iitem) => {
          item.selected = false;
          return item;
        });
        return group;
      });
    };
    const transferData = (mySource : any, myDestination : any) => {
      mySource.data = mySource.data.filter((group : any) => {
        const destGroup = { label: group.label, items: [] };
  
        // filter out all selected items and groups from source
        group.items = group.items.filter((item : any) => {
          if (item.selected) {
            destGroup.items.push({ ...item, selected: false });
          }
          return !item.selected || item.selected === false;
        });
  
        // add selected items from source to destination
        if (destGroup.items.length) {
          const indexOfGroup = myDestination.data.findIndex(
            (dGroup : IGroup) => dGroup.label === destGroup.label
          );
          if (indexOfGroup != -1) {
            myDestination.data[indexOfGroup].items = [
              ...myDestination.data[indexOfGroup].items,
              ...destGroup.items,
            ];
          } else {
            myDestination.data.push(destGroup);
          }
        }
  
        return group.items.length;
      });
  
      // fire event to send back the modified lists
      onListChange();
    };
  
    // eslint-disable-next-line
    const onListChange = () => {
      emit('onListChange', source.data, destination.data);
    };
  </script>
  
  <style lang="css">
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    .container {
      display: flex;
      flex-direction: row;
      gap: 10px;
    }
  
    .side {
      width: 350px;
      display: flex;
      flex-direction: column;
    }
  
    .middle {
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      gap: 0.5rem;
    }
  
    .arrow-button {
      border: 0;
      outline: 0;
      background-color: #ff4500;
      color: #fff;
      padding: 0.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 0.5rem;
      cursor: pointer;
    }
  
    .arrow-button .arrow-right {
      width: 1.5rem;
      height: 1.5rem;
      fill: #fff;
    }
  
    .arrow-button .arrow-left {
      width: 1.5rem;
      height: 1.5rem;
      fill: #fff;
      transform: scale(-1);
    }
  
    .side input {
      width: 100%;
      padding: 0.6rem;
      outline: none;
      border: 1px solid #aaa;
      border-bottom: 0;
    }
  
    .box {
      width: 100%;
      height: 300px;
      overflow-y: auto;
      border: 1px solid #aaa;
    }
  
    .tools {
      width: 100%;
      display: flex;
    }
  
    .tools div {
      width: 50%;
      padding: 0.6rem;
      text-align: center;
      cursor: pointer;
    }
  
    .select-all {
      background-color: #ff4500;
      color: #fff;
    }
  
    .select-none {
      background-color: #888;
      color: #fff;
    }
  
    .list {
      list-style: none;
    }
  
    .list .item {
      border-bottom: 1px solid #eee;
      display: block;
      font-size: 0.9rem;
      padding: 0.6rem 0;
      padding-left: 15px;
      color: #333;
      cursor: pointer;
    }
  
    .item:hover {
      background-color: #ff4500;
      color: #fff;
    }
  
    .label {
      color: #888;
      padding: 0.6rem 0;
      padding-left: 5px;
      border-bottom: 1px solid #eee;
      width: 100%;
      display: block;
      cursor: pointer;
    }
  
    .selected {
      background-color: #ddd;
      color: #fff;
    }
  </style>
  