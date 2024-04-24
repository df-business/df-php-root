//依赖于animal.js
define([
 'animal'
], function(obj) {
 'use strict';
 return {
say(){
 obj.say("喵喵");
 obj.showName("猫");
}
 }
});