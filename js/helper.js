import { DATA_PAGE } from './data';
import { stateCreator } from './state';
import { upperFirst } from 'lodash';
import store from './store';

export function isMail(s){
  let reg = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/i;
  return reg.test(s)
}

export function isName(s){
  let reg = /^[^0-9!<>,;?=+()@#"°{}_$%:]+$/i;
  return reg.test(s);
}

export function isSafe(s){
  let reg = /^[^<>{}]+$/g;
  return reg.test(s);
}
export function scrollToTop(duration){

  let scrollTop = document.querySelector('body').scrollTop;

  if (duration <= 0) return;

  let perTick = scrollTop / duration * 10;
  setTimeout(function() {
    document.querySelector('body').scrollTop = scrollTop - perTick;
    if (scrollTop === 0) return;
    scrollToTop(duration - 10);
  }, 10);
}

export function scrollToElement(el, duration){

  let scrollTop = document.querySelector('body').scrollTop;
  let heightToScroll = el.offsetTop;

  if (duration <= 0) return;

  let difference = heightToScroll  - scrollTop;
  let perTick = difference / duration * 10;
  setTimeout(function() {
    document.querySelector('body').scrollTop = scrollTop + perTick;
    if (scrollTop === heightToScroll) return;
        scrollToElement(el, duration - 10);
  }, 10);
}
export function getRouteComponent(ID){
  return DATA_PAGE.routes.find((route) => route.ID === ID);
}

export function getRouteComponentID(name) {
  return DATA_PAGE.routes.find((route) => route.name === name);
}

export function getComponentName(ID) {
  return getRouteComponent(ID).component.toLowerCase()
}


export function getAllChunksForComponent(ID){
  return Object.keys(stateCreator()[getComponentName(ID)]);
}

export function boundMutationForChunks(component = '', chunks = []){
  let boundChunksWithMethods = [];
  chunks.forEach((chunk)=>{
    boundChunksWithMethods.push({
      method:'set'+ upperFirst(component)+upperFirst(chunk),
      chunkType:chunk
    })
  });
  return boundChunksWithMethods ;
}



export function boundedChunksWithMutations(ID){
  let component = getComponentName(ID);
  let chunks = getAllChunksForComponent(ID);

  return boundMutationForChunks(component, chunks);

}

export function componentNeedUpdate(ID){

  let component = getComponentName(ID);
  let chunks = getAllChunksForComponent(ID);
  let doesNeedUpdate = false;

  chunks.some((chunk) => {
    let isChunkAlreadyHere  = () => {
      if(store.state[component] === store.state['contact']){
        return !!store.state[component]['desc'].length
      } else {
        return !!store.state[component][chunk].length
      }
    } ;
    return isChunkAlreadyHere() ? doesNeedUpdate = false : doesNeedUpdate = true;
  });
  return doesNeedUpdate;
}
