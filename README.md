<!DOCTYPE html>
<html >
<head>
  <meta charset="UTF-8">
  <title>Digital Business Card</title>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">

  
      <style>
	  
		
@import url(https://fonts.googleapis.com/css?family=Open+Sans: 400, 300);
@import url(https://fonts.googleapis.com/css?family=Poiret+One);

/* fonts */

html, 
body {
  background: #05aefc;
  font-family: 'Open Sans', sans-serif;
}

.container {
  -webkit-perspective: 2500px;
          perspective: 2500px;
}

.card {
  background: white;
  height: 300px;
  width: 600px;
  margin: 3em auto;
  border-radius: .2em;
  box-shadow: 0 2.5em .9em -2em #555;
  position: absolute;
  left: 50%;
  -webkit-transform: translateX(-50%);
          transform: translateX(-50%);
  overflow: hidden;
  -webkit-backface-visibility: hidden;
          backface-visibility: hidden;
  -webkit-transition: -webkit-transform .8s cubic-bezier(.63,-0.32,.4,1.39);
          transition: -webkit-transform .8s cubic-bezier(.63,-0.32,.4,1.39);
          transition: transform .8s cubic-bezier(.63,-0.32,.4,1.39);
          transition: transform .8s cubic-bezier(.63,-0.32,.4,1.39), -webkit-transform .8s cubic-bezier(.63,-0.32,.4,1.39);
}

.card-flip {
  -webkit-transform: rotateY(180deg);
          transform: rotateY(180deg);
}

.initials {
  display: inline-block;
  font-family: 'Poiret One';
  font-size: 7em;
  color: #333;
  font-weight: 500;
  left: 50%;
  -webkit-transform: translateX(-50%);
          transform: translateX(-50%);
  position: relative;
  text-align: center;
  border-bottom: 1px solid #FB0044;
  margin-bottom: 8px;
  margin-bottom: .5rem;
}

.initials-back {
  font-size: 3em;
  margin: .5em 0;
  border-bottom: 1px solid #FB0044;
}

.initial-1 {
  -webkit-transform: translateX(900%);
          transform: translateX(-100%); 
}

.initial-2 {
  color: #05aefc; 
  -webkit-transform: translateX(-255%); 
          transform: translateX(-80%);
}

.initials-3 {
  color: #09FC83;  
  -webkit-transform: translateX(-305%);  
          transform: translateX(-305%);
}

.desc {
  font-weight: 300;
  position: relative;
  width: 100%;
  text-align: center;
}

.contact {
  text-align: center; 
  font-weight: 300;
  position: relative; 
  margin: 2em 0 1em 0;
}

hr {
  width: 90%;
}

.twitter-front {
  width: 100%;
  text-align: center;
  margin-top: 1em;
}

#twitter-front {
  color: #09FC83;
  text-decoration: none;
}

.links {
  width: 80%;
  text-align: center;
  border-top: 1px solid #05aefc;
  border-bottom: 1px solid #09FC83;
  margin: 0 auto;
}

.links > a {
  margin: 0 1em;
}

#twitter-back {
  height: 50px;
  width: 50px;
}

#github-back {
  height: 35px;
  width: 35px;
  position: relative;
  top: -.4em;
}

#linkedin-back {
  width: 35px;
  height: 30px;
  position: relative;
  top: -.5em;
}

#email-back {
  height: 50px;
  width: 50px;
}

#codepen-back {
  height: 38px;
  width: 38px;
  position: relative;
  top: -.3em;
}
.outer-ring,
.inner-box {
  fill: #333;
}

#wave {
  bottom: -1.8em;
  position: relative;
}

#click-me {
  color: #333;
  position: absolute;
  left: 50%;
  -webkit-transform: translateX(-50%);
          transform: translateX(-50%);
  top: 1em;
  -webkit-animation: fade 3s infinite ease-in-out;
          animation: fade 3s infinite ease-in-out;
}

@-webkit-keyframes fade {
  0% {
    opacity: 1;
  }
  
  50% {
    opacity: 0;
  }
   
  100% {
    opacity: 1;
  }
}

@keyframes fade {
  0% {
    opacity: 1;
  }
  
  50% {
    opacity: 0;
  }
   
  100% {
    opacity: 1;
  }
}
	  
	  </style>

  
</head>

<body>
  <span id="click-me">Bibhash Kalita!</span>
<div class="container">
  <div class="card card-front">
    <div class="initials initial-1">B</div>
    <div class="initials initial-2">K</div>
    <div class="initials initials-3"></div>
    <div class="desc">Developer</div>
    <div class="twitter-front">
      <a id="twitter-front" href="https://bibhashk.github.io/BibhashK.github.io/docs/index.html" target="_blank">Click-Me to View My Portfolio</a>
    </div>
    <svg id="wave" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="640" height="480">
        <desc iVinci="yes" version="4.6" gridStep="20" showGrid="no" snapToGrid="no" codePlatform="0"/>
        <g id="Layer1" name="Layer 1" opacity="1">
            <g id="Shape1">
                <desc shapeID="1" type="0" basicInfo-basicType="0" basicInfo-roundedRectRadius="12" basicInfo-polygonSides="6" basicInfo-starPoints="5" bounding="rect(-279.878,-31.2762,559.756,62.5526)" text="" font-familyName="Helvetica" font-pixelSize="20" font-bold="0" font-underline="0" font-alignment="1" strokeStyle="0" markerStart="0" markerEnd="0" shadowEnabled="0" shadowOffsetX="0" shadowOffsetY="2" shadowBlur="4" shadowOpacity="160" blurEnabled="0" blurRadius="4" transform="matrix(1.03603,0,0.00804184,0.959194,290.713,50.5)" pers-center="0,0" pers-size="0,0" pers-start="0,0" pers-end="0,0" locked="0" mesh="" flag=""/>
                <path id="shapePath1" d="M0.985291,78.3775 C16.5257,78.3775 42.8604,82.1398 63.1471,78.3775 C78.2678,75.5732 93.5915,69.3044 104.427,59.1936 C124.987,40.0097 130.696,36.5417 145.708,40.0097 C164.697,44.3964 166.589,59.1936 187.471,78.3775 C198.476,88.4883 213.307,59.1936 228.751,59.1936 C244.195,59.1936 256.058,83.6879 270.353,78.3775 C297.476,68.3016 303.165,25.286 332.032,20.8258 C356.565,17.0354 373.062,47.3313 394.516,59.1936 C407.821,66.5503 420.673,78.3775 436.118,78.3775 C457.959,78.3775 496.919,59.1936 518.76,59.1936 C534.205,59.1936 560.189,78.3775 580.909,78.3775 " style="stroke:none;fill-rule:evenodd;fill:#fb0044;fill-opacity:0.878431;"/>
            </g>
        </g>
        <g id="Layer2" name="Layer 2" opacity="1">
            <g id="Shape2">
                <desc shapeID="2" type="0" basicInfo-basicType="0" basicInfo-roundedRectRadius="12" basicInfo-polygonSides="6" basicInfo-starPoints="5" bounding="rect(-269.999,-35.2583,539.998,70.5166)" text="" font-familyName="Helvetica" font-pixelSize="20" font-bold="0" font-underline="0" font-alignment="1" strokeStyle="0" markerStart="0" markerEnd="0" shadowEnabled="0" shadowOffsetX="0" shadowOffsetY="2" shadowBlur="4" shadowOpacity="160" blurEnabled="0" blurRadius="4" transform="matrix(1.03704,0,0,0.911372,280.5,48.1757)" pers-center="0,0" pers-size="0,0" pers-start="0,0" pers-end="0,0" locked="0" mesh="" flag=""/>
                <path id="shapePath2" d="M0.500061,78.2669 C16.0556,78.2669 41.9815,78.2669 62.7222,78.2669 C109.1,78.2669 124.944,41.812 166.426,23.5845 C203.528,7.28141 207.907,60.0394 228.648,78.2669 C246.274,93.7572 268.203,16.0423 292.78,16.0423 C313.816,16.0423 311.611,20.5 353.093,60.0394 C372.975,78.9906 394.574,78.2669 415.315,78.2669 C437.177,78.2669 476.415,60.0395 498.278,60.0394 C520.14,60.0395 544.944,73.71 560.5,78.2669 " style="stroke:none;fill-rule:evenodd;fill:url(#radialGradientFill2);fill-opacity:1;"/><defs><radialGradient id="radialGradientFill2" gradientUnits="userSpaceOnUse" cx="285.313" cy="39.062" r="291.115" fx="-188.613" fy="51.8212"><stop offset="0" stop-color="#ffffff" stop-opacity="1"/><stop offset="0.103307" stop-color="#097afc" stop-opacity="0.878431"/></radialGradient></defs>
            </g>
        </g>
        <g id="Layer3" name="Layer 3" opacity="1">
            <g id="Shape3">
                <desc shapeID="3" type="0" basicInfo-basicType="0" basicInfo-roundedRectRadius="12" basicInfo-polygonSides="6" basicInfo-starPoints="5" bounding="rect(-271.999,-21.1985,543.998,42.3969)" text="" font-familyName="Helvetica" font-pixelSize="20" font-bold="0" font-underline="0" font-alignment="1" strokeStyle="0" markerStart="0" markerEnd="0" shadowEnabled="0" shadowOffsetX="0" shadowOffsetY="2" shadowBlur="4" shadowOpacity="160" blurEnabled="0" blurRadius="4" transform="matrix(1.03676,0,0,0.943465,282.498,60.5)" pers-center="0,0" pers-size="0,0" pers-start="0,0" pers-end="0,0" locked="0" mesh="" flag=""/>
                <path id="shapePath3" d="M4.64236,78.466 C-16.093,78.466 46.732,83.0425 66.8482,78.466 C102.958,70.251 133.304,40.7274 170.525,40.7274 C195.445,40.7274 208.149,74.7378 232.731,78.466 C254.29,81.7359 273.08,59.5967 294.937,59.5967 C310.392,59.5967 321.162,80.7782 336.407,78.466 C366.897,73.8417 388.859,45.3517 419.348,40.7274 C434.593,38.4153 467.204,54.3733 481.554,59.5967 C501.848,66.9837 522.556,73.642 543.76,78.466 C550.466,79.9915 564.495,78.466 564.495,78.466 C564.495,78.466 184.348,78.466 4.64236,78.466 Z" style="stroke:none;fill-rule:evenodd;fill:#09fc83;fill-opacity:1;"/>
            </g>
        </g>
        <g id="Layer4" name="Layer 4" opacity="1">
            <g id="Shape4">
                <desc shapeID="4" type="0" basicInfo-basicType="0" basicInfo-roundedRectRadius="12" basicInfo-polygonSides="6" basicInfo-starPoints="5" bounding="rect(-260.001,-22.4804,520.002,44.9608)" text="" font-familyName="Helvetica" font-pixelSize="20" font-bold="0" font-underline="0" font-alignment="1" strokeStyle="0" markerStart="0" markerEnd="0" shadowEnabled="0" shadowOffsetX="0" shadowOffsetY="2" shadowBlur="4" shadowOpacity="160" blurEnabled="0" blurRadius="4" transform="matrix(1.07692,0,0,0.889664,280.5,60.5)" pers-center="0,0" pers-size="0,0" pers-start="0,0" pers-end="0,0" locked="0" mesh="" flag=""/>
                <path id="shapePath4" d="M0.499969,79.3816 C0.499969,79.3816 43.7934,81.898 65.1154,79.3816 C94.4196,75.9232 121.667,61.5883 151.269,61.5883 C173.973,61.5883 193.181,79.3816 215.885,79.3816 C231.938,79.3816 242.908,61.5883 258.962,61.5883 C275.015,61.5883 286.464,82.5982 302.038,79.3816 C321.739,75.3129 325.203,47.085 345.115,43.795 C367.378,40.1167 387.027,61.5883 409.731,61.5883 C432.434,61.5883 458.292,30.5327 474.346,43.795 C495.885,61.5883 560.5,79.3816 560.5,79.3816 C560.5,79.3816 0.499969,79.3816 0.499969,79.3816 Z" style="stroke:none;fill-rule:evenodd;fill:#fcfafc;fill-opacity:0.768627;"/>
            </g>
        </g>
    </svg>
  </div> 
  <div class="card card-back card-flip">
    <div class="initials initials-back">Bibhash Kalita</div>
    <div class="desc desc-back">Developer with an eye for design</div>
    <div class="contact">Get in touch</div>
    <div class="links">
      <!--<a href="https://twitter.com/willajohnson" target="_blank"><img id="twitter-back" src="https://willalanjohnson.com/images/twitter-gray.png"></a>
      <a href="http://linkedin.com/willalanjohnson" target="_blank"><img id="linkedin-back" src="https://willalanjohnson.com/images/linkedin.png"></a>
      <a href="https://github.com/MrDoctorJ" target="_blank"><img id="github-back" src="https://willalanjohnson.com/images/github.png"></a>
      <a href="mailto:will@willalanjohnson.com"><img id="email-back" src="https://willalanjohnson.com/images/email-icon.png"></a>
      <a href="http://codepen.io/willalanjohnson/" target="_blank"> 
        <svg id="codepen-back">
          <use xlink:href="#codepen-logo"></use> -->
		  <p>mail me @ bibhaskalita94@gmail.com</p>
        </svg>  
      </a>
    </div>
  </div>
</div>


<svg style="display: none;" xmlns="http://www.w3.org/2000/svg"><symbol id="codepen-logo" viewBox="0 0 120 120"><path class="outer-ring" d="M60.048 0C26.884 0 0 26.9 0 60.048s26.884 60 60 60.047c33.163 0 60.047-26.883 60.047-60.047 S93.211 0 60 0z M60.048 110.233c-27.673 0-50.186-22.514-50.186-50.186S32.375 9.9 60 9.9 c27.672 0 50.2 22.5 50.2 50.186S87.72 110.2 60 110.233z"/><path class="inner-box" d="M97.147 48.319c-0.007-0.047-0.019-0.092-0.026-0.139c-0.016-0.09-0.032-0.18-0.056-0.268 c-0.014-0.053-0.033-0.104-0.05-0.154c-0.025-0.078-0.051-0.156-0.082-0.232c-0.021-0.053-0.047-0.105-0.071-0.156 c-0.033-0.072-0.068-0.143-0.108-0.211c-0.029-0.051-0.061-0.1-0.091-0.148c-0.043-0.066-0.087-0.131-0.135-0.193 c-0.035-0.047-0.072-0.094-0.109-0.139c-0.051-0.059-0.104-0.117-0.159-0.172c-0.042-0.043-0.083-0.086-0.127-0.125 c-0.059-0.053-0.119-0.104-0.181-0.152c-0.048-0.037-0.095-0.074-0.145-0.109c-0.019-0.012-0.035-0.027-0.053-0.039L61.817 23.5 c-1.072-0.715-2.468-0.715-3.54 0L24.34 46.081c-0.018 0.012-0.034 0.027-0.053 0.039c-0.05 0.035-0.097 0.072-0.144 0.1 c-0.062 0.049-0.123 0.1-0.181 0.152c-0.045 0.039-0.086 0.082-0.128 0.125c-0.056 0.055-0.108 0.113-0.158 0.2 c-0.038 0.045-0.075 0.092-0.11 0.139c-0.047 0.062-0.092 0.127-0.134 0.193c-0.032 0.049-0.062 0.098-0.092 0.1 c-0.039 0.068-0.074 0.139-0.108 0.211c-0.024 0.051-0.05 0.104-0.071 0.156c-0.031 0.076-0.057 0.154-0.082 0.2 c-0.017 0.051-0.035 0.102-0.05 0.154c-0.023 0.088-0.039 0.178-0.056 0.268c-0.008 0.047-0.02 0.092-0.025 0.1 c-0.019 0.137-0.029 0.275-0.029 0.416V71.36c0 0.1 0 0.3 0 0.418c0.006 0 0 0.1 0 0.1 c0.017 0.1 0 0.2 0.1 0.268c0.015 0.1 0 0.1 0.1 0.154c0.025 0.1 0.1 0.2 0.1 0.2 c0.021 0.1 0 0.1 0.1 0.154c0.034 0.1 0.1 0.1 0.1 0.213c0.029 0 0.1 0.1 0.1 0.1 c0.042 0.1 0.1 0.1 0.1 0.193c0.035 0 0.1 0.1 0.1 0.139c0.05 0.1 0.1 0.1 0.2 0.2 c0.042 0 0.1 0.1 0.1 0.125c0.058 0.1 0.1 0.1 0.2 0.152c0.047 0 0.1 0.1 0.1 0.1 c0.019 0 0 0 0.1 0.039L58.277 96.64c0.536 0.4 1.2 0.5 1.8 0.537c0.616 0 1.233-0.18 1.77-0.537 l33.938-22.625c0.018-0.012 0.034-0.027 0.053-0.039c0.05-0.035 0.097-0.072 0.145-0.109c0.062-0.049 0.122-0.1 0.181-0.152 c0.044-0.039 0.085-0.082 0.127-0.125c0.056-0.055 0.108-0.113 0.159-0.172c0.037-0.045 0.074-0.09 0.109-0.139 c0.048-0.062 0.092-0.127 0.135-0.193c0.03-0.049 0.062-0.098 0.091-0.146c0.04-0.07 0.075-0.141 0.108-0.213 c0.024-0.051 0.05-0.102 0.071-0.154c0.031-0.078 0.057-0.156 0.082-0.234c0.017-0.051 0.036-0.102 0.05-0.154 c0.023-0.088 0.04-0.178 0.056-0.268c0.008-0.045 0.02-0.092 0.026-0.137c0.018-0.139 0.028-0.277 0.028-0.418V48.735 C97.176 48.6 97.2 48.5 97.1 48.319z M63.238 32.073l25.001 16.666L77.072 56.21l-13.834-9.254V32.073z M56.856 32.1 v14.883L43.023 56.21l-11.168-7.471L56.856 32.073z M29.301 54.708l7.983 5.34l-7.983 5.34V54.708z M56.856 88.022L31.855 71.4 l11.168-7.469l13.833 9.252V88.022z M60.048 67.597l-11.286-7.549l11.286-7.549l11.285 7.549L60.048 67.597z M63.238 88.022V73.14 l13.834-9.252l11.167 7.469L63.238 88.022z M90.794 65.388l-7.982-5.34l7.982-5.34V65.388z"/></symbol></svg>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>

    <script>
		'use strict';

$('a').click(function (e) {
  e.stopPropagation();
});

$('.card').click(function () {
  $('.card-front').toggleClass('card-flip');
  $('.card-back').toggleClass('card-flip');
});
	</script>

</body>
</html>
