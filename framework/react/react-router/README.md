# Highly Interactive React Force Layout

![demo](https://raw.githubusercontent.com/hkjpotato/react-force/master/demo.gif)

[Video](https://youtu.be/6x3FctrLcAc)

[Simple Demo](http://bl.ocks.org/hkjpotato/55a25dd75d7a0e8d3d2129a8326b61ca)


### Introduction
After reviewing uber's [react-vis-force](https://github.com/uber/react-vis-force), Sally Wu's [3 approaches](http://bl.ocks.org/sxywu/61a4bd0cfc373cf08884) for React + D3 force and other online resources for integrating React and D3 force layout, I finally come up with this HOC component ```createInteractiveForce``` that allows you to make interactive and scalable graph vis using force layout algorithm in React.

### Key Ideas
Basically, I don't let React do position related update. Also, I strictly separate the data into ```React``` controlled data and ```Force``` controlled data.

React control ```state``` related data such as ```selected```, ```focused```, ```nodes```, ```links```. Their update will go through React's reconciliation. However, the position related data is controlled by Force. The update of position (```x``` and ```y```), triggered by ```tick``` event, will perform directly on the dom node to achieve good performance.

 - State data (React) and position data (Force) are separated.
 - React's data stays immutable.
 - Let Force mutates position data.
 - Use ```key``` to communicate with each other.
 - Animation happens outside React.

Please check [this](http://bl.ocks.org/hkjpotato/55a25dd75d7a0e8d3d2129a8326b61ca) simplified version to get the basic idea as well.

### How to use
This is a demo version, clone it and runs ```npm install```, then run ```npm run start```. You can see an example on ```localhost:3000```.

Check the ```index.js``` in the ```src``` file to get an idea of how to create your own force graph. You have 3 HOC to help you ```createForceNode```, ```createForceLink```, and ```createInteractiveForce```.

Your presentational components ```Node``` and ```Link``` will receive certain props. You need to set ```ref={domRef}``` to your dom element so that its position can be directly updated.

Currently, I assume the ```nodes``` all have a ```name``` attribute as the key. Each link has ```source``` and ```target``` attributes, which are the ```name```of the related node. You can modified the ```getNodeKey``` and ```getLinkKey``` function in ```utils/d3-force```.

### Challenges
The biggest challenge is how to let Force and React talk to each other. To solve this problem, I maintain a ```keyToInstance``` map for all nodes and links instances to quickly access the dom node of each React instance. I also maintain a ```keyToForceNode``` map to quickly access the real time location generated by force.

The second challenge is about updating. To reduce unnecessary re-render, I borrow the idea from uber's react-vis-force, which uses the ```Set``` to quickly compare the keys of react's nodes and force's nodes, and only does force re-binding when there are new nodes and links.