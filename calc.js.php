/**/var traitActive = new Array();
var possibleSkills = new Array();
var activeSkills = new Array();
var powersLoc = new Array();
var skillsLoc = new Array();
var activeDiscs = new Array();
var raceNames = new Array("Aelfborn","Aracoix","Centaur","Dwarf","Elf","Half Giant","Human","Irekei","Minotaur","Nephilim","Shade","Vampire");
var classNames = new Array("Fighter","Healer","Mage","Rogue");
var professionID = new Array("Assassin","Barbarian","Bard","Channeler","Confessor","Crusader","Doomsayer","Druid","Fury","Huntress","Necromancer","Nightstalker","Prelate",
	"Priest","Ranger","Scout","Sentinel","Templar","Thief","Warlock","Warrior","Wizard","Fighter","Healer","Mage","Rogue");
var discArray = new Array ('animator','archer','archmage','artillerist','battlemagus','belgosch','berserker','blackmask','blademaster','bladeweaver','bloodhorn','bloodprophet','bountyhunter','clanwarden','commander',
	'conjurer','darkknight','darksworn','drannok','enchanter','forgemaster','giantkiller','gladiator','gorgoi','huntsman','knight','prospector','ratcatcher','runecaster','saboteur','sanctifier','sapper','savant',
	'shroudborne','skydancer','stormlord','strigoi','summoner','sundancer','thrall','traveller','undeadhunter','valkyr','werebear','wererat','werewolf','wyrmslayer');
var curRace;
var curProfession;
var curClass;
var selectedPower;
var trainingPoints;
var powerCount = 0;
var skillCount = 0;
var powerMenuDefault = true;
var discMenuDefault = false;
var lastFocused;
var scrollLock;
var intFocus = false;
var capActive = false;

var minArrayId = new Array();	//add base information like race and class
var minArrayValue = new Array();

var strength = -1;
var dexterity = -1;
var constitution = -1;
var spirit = -1;
var intelligence = -1;

var traitEffectNameArray = new Array (traitEffectName0, traitEffectName1, traitEffectName2, traitEffectName3);
var traitEffectArray = new Array (traitEffect0, traitEffect1, traitEffect2, traitEffect3);
var attributes = new Array("Strength","Dexterity","Constitution","Intelligence","Spirit");

var initAelfborn = new Array(40,50,40,45,35,95,120,95,105,85,25,67108863);		//the big number at the end is the binary flags
var initAracoix = new Array(50,55,45,35,30,115,120,105,85,85,15,58793197);		//it contains the classes and professions that each race can take
var initCentaur = new Array(45,35,55,35,50,110,85,125,85,105,20,18168364);
var initDwarf = new Array(45,35,60,30,40,110,80,140,70,100,15,1061420);
var initElf = new Array(35,60,35,50,40,70,140,70,120,100,15,48217791);
var initHalfGiant = new Array(60,40,60,30,30,150,65,140,85,60,20,17894184);
var initHuman = new Array(40,40,40,40,40,100,100,100,100,100,30,67108863);
var initIrekei = new Array(40,55,40,45,30,85,130,90,110,85,15,46357695);
var initMinotaur = new Array(75,25,70,25,25,170,70,140,65,65,15,17301548);
var initNephilim = new Array(55,15,40,65,30,140,60,90,130,80,15,63571199);
var initShade = new Array(40,50,40,45,30,90,115,95,110,90,20,37784827);
var initVampire = new Array(45,50,45,50,30,120,120,120,120,65,5,33588475);
var raceArrays = new Array(initAelfborn,initAracoix,initCentaur,initDwarf,initElf,initHalfGiant,initHuman,initIrekei,initMinotaur,initNephilim,initShade,initVampire);
var fighterArray = new Array(5,0,5,-10,0,588,1118390);	//these binary flags hold which profession can be with each class
var healerArray = new Array(0,-10,5,0,5,646,508672);
var mageArray = new Array(-10,0,0,5,5,646,2926597);
var rogueArray = new Array(0,5,0,5,-10,588,3675336);
var classArray = new Array(fighterArray,healerArray,mageArray,rogueArray);
var skillCap = new Array(29,32,34,36,38,40,42,43,45,47,48,49,51,52,53,55,56,57,58,59,60,62,63,64,65,66,67,68,68,69,70,71,72,73,74,75,76,76,77,78,79,80,80,81,82,83,83,84,85,85,86,87,88,88,89,90,90,91,92,92,93,94,94,
	95,95,96,97,97,98,99,99,100,100,101,101,102,103,103,104,104,105,105,106,106,107,108,109,109,110,110,111,112,112,113,113,114,115,115,116,116,117,118,118,119,119,120,121,121,122,122,123,124,124,125,125,126,127,
	127,128,128,129,130,130,131,131,132,133,133,134,134,135,136,136,137,137,138,139,139,140,140,141,142,142,143,143,144,145,145,146,146,147,148,148,149,149,150,151,151,152,152,153,154,154,155,155,156,157,157,158,
	158,159,160,160,161,161,162,163,163,164,164,165,166,166,167,167,168);
var scrollMsg = true;

function arraySearchB(arr, obj) {	//searches an array for 'obj' and return the true if found, false if not
	for(var i=0; i<=arr.length-1; i++) {
		if (arr[i] == obj) {
			return true;
		}
	}
	return false;
}

function arraySearchI(arr, obj) {	//searches an array for 'obj' and return the index of the first one found, if not -1
	for(var i=0; i<=arr.length-1; i++) {
		if (arr[i] == obj) {
			return i;
		}
	}
	return -1;
}

function addStatRune(id) { //function that adds a non-starting trait statistical rune of any kind
	var effectName;
	var effectValue;
	
	stat = id.substr(0,id.length-1);
	var cur = document.getElementById("cur"+id.substr(0,id.length-1)); //grabs the current stat
	var min = document.getElementById("min"+id.substr(0,id.length-1)); //grabs the min stat
	var max = document.getElementById("max"+id.substr(0,id.length-1)); //grabs the max stat
	var remaining = document.getElementById("statPoints");
	var runeType = parseInt(id.charAt(id.length-1))+1;
	var runeNames = new Array("Enhanced ","Exceptional ","Amazing ","Incredible ","Great ","Heroic ","Legendary "," of the Gods");

	var cost = new Array(0,3,4,5,8,9,11,12,15);

	if (parseInt(cur.value) >= (85+(runeType-1)*5) /*&& window[stat] == -1*/ && parseInt(remaining.value) >= cost[runeType]) { //need to add remove statements
		if (window[stat.toLowerCase()] != -1) {
			max.value = parseInt(max.value)-((window[stat.toLowerCase()])*5);
			remaining.value = parseInt(remaining.value) + cost[window[stat.toLowerCase()]] + ((parseInt(cur.value)-(window[stat.toLowerCase()]+1))-parseInt(max.value));
			cur.value = max.value;
			var check = document.getElementById("appliedrunes").options;
			for (i=0; i<=check.length-1; i++) {
				if (check[i].value == stat+(window[stat.toLowerCase()])) {
					document.getElementById("appliedrunes").remove(i);
					break;
				}
			}
		}
		if (runeType == 8) {	//of the gods name and bonus adjust
			var discription = stat+runeNames[runeType-1];
			var bonus = 10;
		} else {
			var discription = runeNames[runeType-1]+stat;
			var bonus = runeType+1;
		}
		remaining.value = parseInt(remaining.value) - cost[runeType];	//subtract cost from free stat points
		cur.value = parseInt(cur.value)+bonus;
		max.value = parseInt(max.value)+(runeType)*5;
		min.value = cur.value;
		window[stat.toLowerCase()] = runeType;
		addOption(document.runes.appliedrunes,stat+runeType,discription);	//add rune to selectbox
	} else {
		document.getElementById(id).checked = false;
		document.getElementById(id).blur();
		alert("Statistical requirements not yet met; read the tooltip.");
	}
}

function selectsubclass(id) {	//this is called for ALL the drop down menus at the start (race/class/profession/level)
/*	##############################################################################################
	##	Let me explain what's going on here. initRace is an array that stores the variables		##
	##	that the race stat values are entered into. init<enter race name>. store the individual	##
	##	race's values as well as available class and the race's name. raceArrays store the		##
	##	init<race name> arrays in so they can be accessed via a loop.							##
	##############################################################################################	*/
	var initRace = new Array (document.MinStr.Strength,document.MinDex.Dexterity,document.MinCon.Constitution,document.MinInt.Intelligence,document.MinSpi.Spirit,
		document.Str.Strength,document.Dex.Dexterity,document.Con.Constitution,document.Int.Intelligence,document.Spi.Spirit,document.MaxStr.Strength,
		document.MaxDex.Dexterity,document.MaxCon.Constitution,document.MaxInt.Intelligence,document.MaxSpi.Spirit,document.Points.Remaining);
	var race = parseInt(document.drop_list.race.value);
	var baseClass = parseInt(document.drop_list.subclass.value); //changed from class to baseClass since class is a reserved word in js
	var forArray = new Array(window.raceNames[race-1],window.classNames[baseClass], window.professionID[parseInt(document.drop_list.profession.value)]);
	
	switch (id) {
		case "race":
			// ON selection of category this function will work
			removeAllOptions(document.drop_list.profession);
			removeAllOptions(document.runes.appliedrunes);
			addOption(document.drop_list.profession,"", "Select A Class");
			removeAllOptions(document.drop_list.subclass);
			addOption(document.drop_list.subclass,"55", "Select A Subclass");
			
		/*	##############################################################################################
			##	The first loop enters the chosen race's (raceArrays[race-1][i]) attributes into their	##
			##	respected variables (like what the switch statement did before). The second loop works	##
			##	out what information to send to 'addOption()' function based in information at the end	##
			##	of each race's array.																	##
			##############################################################################################	*/
			for (var i=0; i<=4; i++) { //you have to love array pointers inside array pointers
				initRace[i].value = window.raceArrays[race-1][i]-5; //this is a bit confusing. The final -5 is adjusting the min stat as opposed to keeping those values in arrays.
			}
			for (var i=5; i<=initRace.length-1; i++) {
				initRace[i].value = window.raceArrays[race-1][i-5]; //the i-5 is making up for the fact that there are five less values in the race arrays.
			}
			var numsBin = binConv(window.raceArrays[race-1][window.raceArrays[race-1].length-1],window.initHuman[window.initHuman.length-1].toString(2).length);
			for (var i=numsBin.length-4;i<=numsBin.length-1;i++) {
				if (numsBin.charAt(i)=="1") {
					addOption(document.drop_list.subclass,i-numsBin.length+4,window.professionID[i]);
				}
			}
			window.curRace = window.raceNames[race-1];
		break;
		case "subclass":	//parseInt converts string to an int
			removeAllOptions(document.drop_list.profession);
			removeAllOptions(document.runes.appliedrunes);
			addOption(document.drop_list.profession,"", "Select A Class");
			for (var i=0;i<=rogueArray.length-3;i++) {
				initRace[i].value = window.raceArrays[race-1][i]+window.classArray[baseClass][i]-5;
				initRace[i+5].value = window.raceArrays[race-1][i]+window.classArray[baseClass][i];
			}
			var numsBin = binConv(window.raceArrays[race-1][window.raceArrays[race-1].length-1],window.initHuman[initHuman.length-1].toString(2).length);
			var numsBinCmp = binConv(window.classArray[baseClass][window.classArray[baseClass].length-1],window.rogueArray[window.rogueArray.length-1].toString(2).length);
			for (var i=0;i<=numsBin.length-4;i++) {
				if (parseInt(numsBinCmp.charAt(i))+parseInt(numsBin.charAt(i)) == 2) {
					addOption(document.drop_list.profession,i,window.professionID[i]);
				}
			}
			window.trainingPoints = window.classArray[baseClass][window.rogueArray.length-2];
			if (race == 7) {	//human extra trains
				window.trainingPoints += 58;
			}
			document.training.point.value = window.trainingPoints;
			//document.hidden.trainingpoint.value = window.classArray[baseClass][window.rogueArray.length-2];
			window.curClass = window.classNames[baseClass];
		break;
		case "profession":
			removeAllOptions(document.drop_list.level);
			addOption(document.drop_list.level, "1", "Level 1");
			addOption(document.drop_list.level, "75", "Level 75");
			window.curProfession = professionID[parseInt(document.drop_list.profession.value)];
			
			window.minArrayValue = new Array();
			window.minArrayId = new Array();
			for (var count=0; count<=4; count++) {	//adds the basic minimums to the minarray for later processing
				window.minArrayValue.push(initRace[count].value);
				window.minArrayId.push(window.attributes[count]);
			}
		break;
		case "level":
			if (document.drop_list.level.value == "75") {
				document.getElementById("traitButtons").className = 'tabContent hide'; //this will hide all the starting traits
				document.getElementById("traitTabs").className = 'tabContent hide';
				document.getElementById("strength75Tab").className = 'tabContent';	//this being the first tab that's open when levelled up
				document.getElementById("level75Buttons").className = '';	//this displays the level 75 buttons
				document.getElementById("race").disabled = true;	//I cannot be bothered to code in rollback when people change mid level 75 so I'll disable the boxes instead
				document.getElementById("subclass").disabled = true;
				document.getElementById("profession").disabled = true;
				removeAllOptions(document.drop_list.level);
				addOption(document.drop_list.level, "75", "Level 75");
				document.Points.Remaining.value=parseInt(document.Points.Remaining.value)+206;
				for (count in forArray) {
					for (var i in skillsFor) {
						if (window.skillsFor[i]==forArray[count]) { //puts all the possible skills into one array
							window.possibleSkills.push(i);
						}
					}
				}
				for (i in window.possibleSkills) { //this only loads skills that do not have any dependant skill requirements. All of that stuff is handled by add_skill()
					if (skillsRequiredSkill[window.possibleSkills[i]]=='') { //puts all the possible skills into one array
						window.activeSkills.push(window.possibleSkills[i]);
						processSkill(window.skillsSkill[window.possibleSkills[i]],window.skillsLevel[possibleSkills[i]],window.possibleSkills[i]);
					}
				}
				add_skill();
				powerSelectInit();
				document.getElementById("printButton").disabled = false;
				discCheck();
			}
	}
}

function addPower() {	//add the appropriate power to the html
	if (powerCount<99) {
		var idArray = new Array("powername","powerrank","powerbonus","powerclear","powermax","powerid");
		window.powerCount += 2;
		var element = document.getElementById('templatePower');
		var copy = element.cloneNode(true);
		var destination = document.getElementById('powerTable');
		var reset = document.getElementById('resetPowers');
		copy.id = "power"+window.powerCount;
		destination.appendChild(copy);

		reset.parentNode.removeChild(reset);
		destination.appendChild(reset);
		
		for (var count=0; count<=1; count++) {
			for (var i=0; i<=idArray.length-1; i++) {
				document.getElementById(idArray[i]+count).id = "placeholder";
				element = document.getElementById(idArray[i]+count);
				element.id = idArray[i]+(window.powerCount+count);
				element.name = idArray[i]+(window.powerCount+count);
				element.value = "";
				document.getElementById("placeholder").id = idArray[i]+count; 
			}
		}
	}
}

function addSkill() {	//this adds the appropriate skill to the html
	if (skillCount<=150) {
		var idArray = new Array("skillid","skillbonus","skillname","skill_percent","skilltrain","skillmin");
		window.skillCount++;
		var element = document.getElementById('templateSkill');
		var copy = element.cloneNode(true);
		var destination = document.getElementById('skillTable');
		var reset = document.getElementById('resetSkills');
		copy.id = "skill"+skillCount;
		destination.appendChild(copy);

		reset.parentNode.removeChild(reset);	//this deletes the reset button (which is no longer on the bottom) and adds it again (making it on the bottom again)
		destination.appendChild(reset);

		for (var i=0; i<=idArray.length-1; i++) { //why is there two element declarations? when this checks there is TWO with the same ID (since we've duplicated an element), we change the first
			document.getElementById(idArray[i]+0).id = "placeholder";
			element = document.getElementById(idArray[i]+0);
			element.id = idArray[i]+window.skillCount;
			element.name = idArray[i]+window.skillCount;
			element.value = "";
			document.getElementById("placeholder").id = idArray[i]+0; //this makes sure that the names and values of the template element remains untouched
		}
	}
}

function clearPower(id) {	//called when the 'clear' X is pressed next to a power
	id = id.replace("powerclear","");
	document.getElementById("powername"+id).value = "";
	document.getElementById("powername"+id).title = "";
	document.getElementById("powerbonus"+id).value = "";
	document.getElementById("powermax"+id).value = "";
	document.getElementById("powerrank"+id).value = "";
	document.getElementById("powerid"+id).value = "";
	add_skill();
}

function powerSelectInit() {	//the initial stat of the power browswer
	if (!window.discMenuDefault) {
		removeAllOptions(document.getElementById("powerSelect"));
		var addRace = false;
		var addClass = false;
		var addProfession = false;
		for (var i=0; i<=window.powersName.length-1; i++) {
			if (window.powersRankMax[i] != "" &&	//if rankMax = NULL than the power cannot be train and is thus a waste of time to include on the list.
				(parseInt(document.getElementById("skill_percent"+arraySearchI(window.skillsLoc,window.powersRequiredSkill1[i])).value) >= window.powersRequiredSkillRank1[i] || window.powersRequiredSkill1[i] == "") &&
				(parseInt(document.getElementById("skill_percent"+arraySearchI(window.skillsLoc,window.powersRequiredSkill2[i])).value) >= window.powersRequiredSkillRank2[i] || window.powersRequiredSkill2[i] == "") &&
				(parseInt(document.getElementById("powerrank"+arraySearchI(window.powersLoc,window.powersRequiredPower1[i])).value) + 
				parseInt(document.getElementById("powerbonus"+arraySearchI(window.powersLoc,window.powersRequiredPower1[i])).value) >= window.powersRequiredPowerRank1[i] || window.powersRequiredPower1[i] == "") &&
				(parseInt(document.getElementById("powerrank"+arraySearchI(window.powersLoc,window.powersRequiredPower2[i])).value) + 
				parseInt(document.getElementById("powerbonus"+arraySearchI(window.powersLoc,window.powersRequiredPower2[i])).value) >= window.powersRequiredPowerRank2[i] || window.powersRequiredPower2[i] == "")) {
				switch (true) {
					case (window.powersFor[i] == window.curRace): addRace = true; break;
					case (window.powersFor[i] == window.curClass): addClass = true; break;
					case (window.powersFor[i] == window.curProfession): addProfession = true;
				}
			}
		}
		if (addRace) {
			addOption(document.getElementById("powerSelect"),"race","Race Powers");
		}
		if (addClass) {
			addOption(document.getElementById("powerSelect"),"class","Class Powers");
		}
		if (addProfession) {
			addOption(document.getElementById("powerSelect"),"profession","Profession Powers");
		}
		if (activeDiscs.length != 0) {
			addOption(document.getElementById("powerSelect"),"discipline","Discipline Powers");
		}
		window.powerMenuDefault = true;
	} else {
		powerOptionSelect("discipline");
	}
	window.discMenuDefault = false;
}

function powerOptionsCheck(valueName) {	//this 'paints' the options in the power browser
	removeAllOptions(powerSelect);
	var proceed;
	for (var i=0; i<=window.powersFor.length-1; i++) {
		proceed = true;
		if (window.powersFor[i] == valueName && window.powersRankMax[i] != "" && !(arraySearchB(window.powersLoc,window.powersName[i]))) {
			if (window.powersRequiredSkill1[i] != "") { //does power need required skill, and is skill present?
				if (arraySearchB(window.skillsLoc,window.powersRequiredSkill1[i])) {
					if ((window.powersRequiredSkillRank1[i] > parseInt(document.getElementById("skill_percent"+arraySearchI(window.skillsLoc,window.powersRequiredSkill1[i])).value))){
						proceed = false;
					}
				} else {
					proceed = false;
				}
			}
			if (window.powersRequiredSkill2[i] != "") { //does power need required skill, and is skill present?
				if (arraySearchB(window.skillsLoc,window.powersRequiredSkill2[i])) {
					if ((window.powersRequiredSkillRank2[i] > parseInt(document.getElementById("skill_percent"+arraySearchI(window.skillsLoc,window.powersRequiredSkill2[i])).value))){
						proceed = false;
					}
				} else {
					proceed = false;
				}
			}
			if (window.powersRequiredPower1[i] != "") {
				if (arraySearchB(window.powersLoc,window.powersRequiredPower1[i])) {
					if ((window.powersRequiredPowerRank1[i] > (document.getElementById("powerrank"+arraySearchI(window.powersLoc,window.powersRequiredPower1[i])).value*1 + 
						1*document.getElementById("powerbonus"+arraySearchI(window.powersLoc,window.powersRequiredPower1[i])).value))) {
						proceed = false;
					}
				} else {
					proceed = false;
				}
			}
			if (window.powersRequiredPower2[i] != "") {
				if (arraySearchB(window.powersLoc,window.powersRequiredPower1[i])) {
					if ((window.powersRequiredPowerRank2[i] > (document.getElementById("powerrank"+arraySearchI(window.powersLoc,window.powersRequiredPower2[i])).value*1 + 
						1*document.getElementById("powerbonus"+arraySearchI(window.powersLoc,window.powersRequiredPower2[i])).value))) {
						proceed = false;
					}
				} else {
					proceed = false;
				}
			}
			if (proceed) {
				addOption(powerSelect,i,window.powersName[i]);
			}
		}
	}
}

function powerOptionSelect(value) {	//this is called before powerOptionsCheck and paints the options
	window.discMenuDefault = false;
	var valueArray = new Array();
	valueArray["class"] = window.curClass;
	valueArray["race"] = window.curRace;
	valueArray["profession"] = window.curProfession;
	valueArray["discipline"] = window.curProfession;
	
	var powerSelect = document.getElementById("powerSelect");
	switch (value) {
		case "class": case "profession": case "race":
			window.powerMenuDefault = false;
			var valueName = valueArray[value];
			window.selectedPower = value;
			powerOptionsCheck(valueName);
		break;
		case "discipline":
			removeAllOptions(powerSelect);
			for (var i=0; i<=window.activeDiscs.length-1; i++) {
				addOption(powerSelect,window.activeDiscs[i],window.disciplinesName[arraySearchI(window.disciplinesKey,window.activeDiscs[i])]);
			}
		break;
		default:
			if (arraySearchB(window.activeDiscs,value)) {
				window.selectedPower = value;
				powerOptionsCheck(window.disciplinesName[arraySearchI(window.disciplinesKey,value)]);
				window.discMenuDefault = true;
			} else {
				value = parseInt(value);
				if (!arraySearchB(window.powersLoc,window.powersName[value]) && parseInt(document.getElementById("remTrains").value)>0) {
					var free = 99; //There is NO way that someone will have 99 active powers so this is a safe fall-through
					var count = 0;
					while (document.getElementById("powername"+count)) {
						if (document.getElementById("powername"+count).value != "") {
							count++;
						} else {
							free = count;
							break;
						}
					}
					if (free == 99) {
						addPower();	//if no free power slots than the first free one will be powerCount
						free = window.powerCount;
					}
					document.getElementById("powername"+free).value = window.powersName[value];
					document.getElementById("powername"+free).title = window.powersDescription[value];
					document.getElementById("powerbonus"+free).value = window.powersRankMin[value];
					document.getElementById("powermax"+free).value = window.powersRankMax[value]-window.powersRankMin[value];
					document.getElementById("powerrank"+free).value = "1";
					document.getElementById("powerid"+free).value = value;
					add_skill();
				}
			}
	}
	updateSkillsLoc();
}

function binConv(nums,maxLength){ //the binary convertor
	var zero = "0";
	var numsBin = nums.toString(2);
	while (numsBin.length<maxLength) {  //this makes sure each binary number is of the same length by padding the beginning with '0'
		numsBin = zero.concat(numsBin);
	}
	return numsBin;
}

function updateSkillsLoc() {	//updates the skill and powers locational global variables when changes are made
	var count = 0;
	window.powersLoc = new Array();
	window.skillsLoc = new Array();
	while (document.getElementById("skillname"+count)) {
		window.skillsLoc.push(document.getElementById("skillname"+count).value);
		count++;
	}
	count = 0;
	while (document.getElementById("powername"+count)) {
		window.powersLoc.push(document.getElementById("powername"+count).value);
		count++;
	}
}

function processSkill(skillName,skillValue,id) {	//when adding a skill it need to check whether or not it exists so not to have two of the one skill.
	var count=0;
	var exists = false;
	while (document.getElementById("skillname"+count)) {
		if (document.getElementById("skillname"+count).value == skillName) {
			document.getElementById("skillbonus"+count).value = document.getElementById("skillbonus"+count).value*1 + parseInt(skillValue);
			exists = true;
			break;
		}
		count++;
	}
	if (!exists) {
		if (!(window.skillCount == 0 && document.getElementById("skillname"+window.skillCount).value == "")) {
			addSkill();
		}
		document.getElementById("skillid"+window.skillCount).value = id;
		document.getElementById("skillname"+window.skillCount).value = skillName;
		document.getElementById("skillbonus"+window.skillCount).value = skillValue;
	}
	updateSkillsLoc();
}

function startingTraits(id) { //search for increased in if than substr from the space (9)
	var applyTrait = true;
	var race = parseInt(document.drop_list.race.value);
	var baseClass = parseInt(document.drop_list.subclass.value);
	
	var key = arraySearchI(window.traitKey,id);
	if (window.traitRequireStat0[key] != "") {
		if (parseInt(document.getElementById("cur"+window.traitRequireStat0[key]).value) < window.traitRequireValue0[key]) {
			applyTrait = false;
			alert("Statistical requirements have not been met: try again sunshine�");
		}
		if (window.traitRequireStat1[key] != "") {
			if (parseInt(document.getElementById("cur"+window.traitRequireStat1[key]).value) < window.traitRequireValue1[key]) {
				applyTrait = false;
				alert("Giant's Blood requires TWO statistical requirements, must be hard remember them both.");
			} else {
				window.minArrayId.push(id+window.traitRequireStat1[key]);	//keeps all of the required stats so they cannot go below
				window.minArrayValue.push(window.traitRequireValue1[key]);
			}
		}
	}
	if (window.traitCost[key] > document.getElementById("statPoints").value || binConv(window.traitRaces[key],parseInt("4095").toString(2).length).charAt(race-1) == 1 ||
		binConv(window.traitClasses[key],parseInt("15").toString(2).length).charAt(baseClass) == 1) {
		applyTrait = false;
		alert("Cost, class or racial requirements have not been met. There's a tooltip popup thing for a reason; use it.");
	}
	if (applyTrait) {
		window.traitActive.push(key);
		if (window.traitKey[key].search("increased") != -1) {	//this is so they are removed when new stat runes are added on top.
			window[window.traitKey[key].substr(9)] = 0;
		}
		for (var i=0; i<=window.traitEffectArray.length-1; i++) {
			var effectName = window.traitEffectNameArray[i][key];
			var effectValue = window.traitEffectArray[i][key]+"";
			if (effectValue.search("~") != -1) {
				var tempNum = parseInt(effectValue.substr(0,effectValue.search("~")));
				var min = document.getElementById("min"+effectName);
				var max = document.getElementById("max"+effectName);
				var cur = document.getElementById("cur"+effectName);
				var newMin = 0;
				var diffMin = window.traitRequireValue0[key] - parseInt(min.value);
				cur.value = parseInt(cur.value)+tempNum;
				if (parseInt(min.value)+tempNum > window.traitRequireValue0[key] && window.traitRequireStat0[key] == effectName) {
					min.value = window.traitRequireValue0[key];
				} else if (parseInt(min.value)+tempNum > window.traitRequireValue1[key] && window.traitRequireStat1[key] == effectName) {
					min.value = window.traitRequireValue1[key];
				}
				
				min.value = parseInt(min.value)+tempNum;
				max.value = parseInt(max.value)+parseInt(effectValue.substr(effectValue.search("~")+1));
				
				
				
				
				/*for (var count=0; count<=window.traitActive.length-1; count++) {	//this code searches the traits min values
					var newkey = window.traitActive[count];
					if (window.traitRequireStat0[newkey] == effectName && (parseInt(cur.value) - window.traitRequireValue0[newkey]) <= newMin) {
						newMin = parseInt(cur.value) - window.traitRequireValue0[newkey];
					}
					if (window.traitRequireStat1[newkey] == effectName && (parseInt(cur.value) - window.traitRequireValue1[newkey]) <= newMin) {
						newMin = parseInt(cur.value) - window.traitRequireValue0[newkey];
					}
				}*/
				/*newMin = parseInt(cur.value) - newMin;
				if (tempNum < 0) {
					min.value = newMin+tempNum;
				} else {
					min.value = newMin;
				}*/
			} else if (effectName != "" && arraySearchB(window.skillsSkill,effectName)) {	//arraySearchB: is the effect a skill? If it's not than it's not yet supported (like Fire or Health)
				window.possibleSkills.push(arraySearchI(window.skillsSkill,effectName));
				window.activeSkills.push(arraySearchI(window.skillsSkill,effectName));
				processSkill(effectName,effectValue,arraySearchI(window.skillsFor,window.traitName[key]));
				add_skill();
			}
		}
		if (window.traitRequireStat1[key] != "") {
			window.minArrayId.push(id+window.traitRequireStat0[key]);	//keeps all of the required stats so they cannot go below
			window.minArrayValue.push(window.traitRequireValue0[key]);
		}
		document.getElementById("statPoints").value = parseInt(document.getElementById("statPoints").value)-window.traitCost[key];
		addOption(document.runes.appliedrunes,id,window.traitName[key]);
	} else {
		document.getElementById(id).checked = false;
	}
}

function discReset() {	//readies the discs after they've all be disabled (after the forth discipline has been removed)
	for ( var i in window.discArray ) {	//enables all of them
		disableRadio(false, window.discArray[i]);
	}
	for ( i in window.discArray ) {	//disables used ones
		if (arraySearchB(window.activeDiscs, window.discArray[i])) {
			document.getElementById(window.discArray[i]).checked = true;
			disableRadio(true, window.discArray[i]);
		}
	}
}

function discCheck() {	//checks if discs can be taken, if not disable
	var idArray = window.discArray;
	var race = parseInt(document.drop_list.race.value);
	var baseClass = parseInt(document.drop_list.subclass.value);
	var profession = parseInt(document.drop_list.profession.value);
	var key;
	var disable;

	for (var i=0; i<=idArray.length-1; i++) {
		key = arraySearchI(window.disciplinesKey,idArray[i]); // !arraySearchB(window.activeDiscs,idArray[i])
		if (!document.getElementById(idArray[i]).checked && !document.getElementById(idArray[i]).disabled && document.drop_list.level.value == "75") {
			if (binConv(window.disciplinesRace[key],12).charAt(race-1) + binConv(window.disciplinesClass[key],4).charAt(baseClass) + binConv(window.disciplinesProfession[key],22).charAt(profession) == "000"
				&& window.activeDiscs.length < 4) {
				document.getElementById(idArray[i]).className = "";
				document.getElementById(idArray[i]).disabled = false;
				document.getElementById(idArray[i]).checked = false;
			} else {
				document.getElementById(idArray[i]).className = "invisbox";
				document.getElementById(idArray[i]).disabled = true;
			}
		}
	}
}

function disciplineAdd(id) {	//add a discipline but doesn't do the checks, that is done by disccheck
	var key = arraySearchI(window.disciplinesKey,id);
	if (window.disciplinesName[key] == "Valkyr") {	//For Valkyr since it's the only disc that adjusts stats
		document.getElementById("curIntelligence").value = parseInt(document.getElementById("curIntelligence").value)-5;
		document.getElementById("minIntelligence").value = document.getElementById("curIntelligence").value;
		document.getElementById("maxStrength").value = parseInt(document.getElementById("maxStrength").value)+25;
	}
	window.activeDiscs.push(id);
	for (var i=0; i<=window.skillsFor.length-1; i++) {
		if (skillsFor[i] == window.disciplinesName[key]) {
			var skillName = window.skillsSkill[i];
			var skillValue = window.skillsLevel[i];
			if (!arraySearchB(window.possibleSkills,i)) {
				window.possibleSkills.push(i);
				window.activeSkills.push(i);
			}
			processSkill(skillName,skillValue,i);
			add_skill();
		}
	}
	addOption(document.runes.appliedrunes,id,window.disciplinesName[key]);
	if (window.powerMenuDefault) {
		powerSelectInit();
	}
	discCheck();
}

function removeAllOptions(selectbox) {	//clears a drop down box
	for (var i=selectbox.options.length-1; i>=0; i--) {
		selectbox.remove(i);
	}
}

function disableRadio (disable, value) { //this function disables or enables radio groups or checkboxes. The two arrays are because you don't like to be consistant with your naming of objects.
	var miscIds = new Array("ambidexterity","blessing","bloodofthedesert","bloodofthedragon","bloodofthenorth","changeling","darkwhispers","divinetouch","fleetoffoot","giantsblood","ironwill",
		"juggernaut","lucky","precise","proficientwithaxes","proficientwithbows","proficientwithcrossbows","proficientwithdaggers","proficientwithhammers","proficientwithpolearms",
		"proficientwithspears","proficientwithstaves","proficientwithswords","snakehandler","stormborn","taintofchaos","taintofmadness","tireless","toughasnails","toughhide","witchsight",
		"bloodprophet","bountyhunter","clanwarden","conjurer","darksworn","enchanter","forgemaster","giantkiller","gladiator","berserker","blackmask","blademaster","bladeweaver","animator",
		"archer","archmage","prospector","ratcatcher","runecaster","savant","shroudborne","skydancer","stormlord","summoner","sundancer","wyrmslayer","traveller","undeadhunter","valkyr",
		"increasedstrength","increasedintelligence","increasedconstitution","increaseddexterity","increasedspirit");
	var skip = false;

	var newvalue = value+" ";
	if (disable) {
		var className = "invisbox";
	} else {
		var className = "";
	}
	switch (value) {
		case "blacksmithsapprentice": case "priestsacolyte": case "taughtbymasterthief": case "warlordspage": case "wizardsapprentice":
			var radgrp = document.traitForm.apprenticeTrait;
		break;
		case "brawler": case "bruiser": case "eyesoftheeagle": case "hunter": case "knifefighter": case "mercenary": case "sellsword": case "sharpshooter": case "wanderer": case "woodsman":
			var radgrp = document.traitForm.backgroundTrait;
		break;
		case "borninthecountry": case "bowyerborn": case "raisedbybarbarians": case "raisedbycentaurs": case "raisedbydwarves": case "raisedbyelves": case "raisedbythievesguild": case "raisedinthewoods":
		case "soldtothepits": case "soldierborn":
			var radgrp = document.traitForm.childhoodTrait;
		break;
		case "healthyasanox": case "hearty":
			var radgrp = document.traitForm.constitutionTrait;
		break;
		case "agile": case "lightningreflexes":
			var radgrp = document.traitForm.dexterityTrait;
		break;
		case "brilliantmind": case "clever":
			var radgrp = document.traitForm.intelligenceTrait;
		break;
		case "knightssquire": case "militarytraining": case "shopkeepersapprentice": case "taughtbyblademaster": case "trainedbymasterofarms": case "travellingperformer":
			var radgrp = document.traitForm.mentorTrait;
		break;
		case "faithoftheages": case "truefaith":
			var radgrp = document.traitForm.spiritTrait;
		break;
		case "herosstrength": case "mighty":
			var radgrp = document.traitForm.strengthTrait;
		break;
		case "bornoftheethyri": case "bornofthegwendannen": case "bornoftheinvorri": case "bornoftheirydnu": case "bornofthetaripontor": case "scionofdarkhelegeur": case "scionofgwaridorn": case "scionoftwathedilion":
			var radgrp = document.traitForm.subraceTrait;
		break;
		case "werewolf": case "werebear": case "huntsman":
			var radgrp = document.traitForm.wereDisc;
		break;
		case "wererat":	//these are special considerations for the sab and wrat restrictions
			var radgrp = document.traitForm.wereDisc;
			document.getElementById("saboteur").disabled = disable;
		break;
		case "belgosch": case "drannok": case "strigoi": case "gorgoi":
			var radgrp = document.traitForm.vampDisc;
		break;
		case "artillerist": case "battlemagus": case "commander": case "sanctifier": case "sapper":
			var radgrp = document.traitForm.commandDisc;
		break;
		case "saboteur":
			var radgrp = document.traitForm.commandDisc;
			document.getElementById("wererat").disabled = disable;
		break;
		case "darkknight": case "knight":
			var radgrp = document.traitForm.knightDisc;
		break;
		case "bloodhorn": case "thrall":
			var radgrp = document.traitForm.minoDisc;
		break;
		default:
			for (var i=0; i<=window.attributes.length-1; i++) {
				if (newvalue.search(window.attributes[i]) != -1) {
					for (var count=1; count<=window[window.attributes[i].toLowerCase()];count++) {	//disables/enables all of the stat runes of chosen type up to and including 'value'
						document.getElementById(window.attributes[i]+(count-1)).className = className;
						document.getElementById(window.attributes[i]+(count-1)).checked = disable;
						document.getElementById(window.attributes[i]+(count-1)).disabled = disable;
					}
				}
			}
			skip = true;
			for (i=0;i<=miscIds.length-1;i++) {
				if (value == miscIds[i]) {
					document.getElementById(value).className = className;
					document.getElementById(value).checked = disable;
					document.getElementById(value).disabled = disable;
				}
			}
	}
	if (!skip) {
		document.getElementById(value).checked = disable;
		for (var i=0;i<=radgrp.length-1;i++) {
			radgrp[i].className = className;
			radgrp[i].disabled = disable;
		}
		discCheck();
	}
	hide_div();	//because the radios are being disabled there is no mouseout so the trait divs will never disappear. This clears them to avoid this little mess.
}

function addOption(selectbox, value, text ) {	//function to add an option to a drop down box
	var optn = document.createElement("OPTION");
	optn.text = text;
	optn.value = value;
	if (selectbox == document.getElementById("powerSelect")) {
		optn.setAttribute('onclick', "powerOptionSelect(this.value)");
	}

	selectbox.options.add(optn);
	disableRadio(true,value);
}

function statAdj(stat,inc) {	//this function controls all of the stat buttons
	var cur = document.getElementById("cur"+stat);
	var min = parseInt(document.getElementById("min"+stat).value);
	var max = document.getElementById("max"+stat);
	
	for (var i=0; i<=window.traitActive.length-1; i++) {	//this code searches the traits min values
		var key = window.traitActive[i];
		if (window.traitRequireStat0[key] == stat && window.traitRequireValue0[key] > min) {
			min = window.traitRequireValue0[key];
		}
		if (window.traitRequireStat1[key] == stat && window.traitRequireValue1[key] > min) {
			min = window.traitRequireValue1[key];
		}
	}

	var statElement = document.getElementById("statPoints");
	switch (inc) {
		case 2: 
			if (parseInt(statElement.value) >= parseInt(max.value)-parseInt(cur.value) && cur.value != max.value) {
				statElement.value = parseInt(statElement.value)-(parseInt(max.value)-parseInt(cur.value));
				cur.value = max.value;
				intCheckMax();
			} else if (cur.value != max.value) {
				cur.value = parseInt(cur.value)+parseInt(statElement.value);
				statElement.value = "0";
				intCheckMax();
			}
		break;
		case 1:
			if (statElement.value != "0" && max.value != cur.value) {
				cur.value = parseInt(cur.value)+1;
				statElement.value = parseInt(statElement.value)-1;
				intCheckMax();
			}
		break;
		case -1:
			if (min != parseInt(cur.value)) {
				cur.value = parseInt(cur.value)-1;
				statElement.value = parseInt(statElement.value)+1;
				window.intFocus = true;
			}
		break;
		case -2:
			if (cur.value != min) {
				statElement.value = parseInt(statElement.value)+(parseInt(cur.value)-min);
				cur.value = min;
				window.intFocus = true;
				intCheckMax();
			}
	}
	add_skill();
}

function intCheckMax() {	//intFocus keeps track if the + or - buttons of intelligence have focus. if they do, check the skillcap.
	if (window.intFocus || window.capActive) {
		var i = 0;
		while (document.getElementById("skill_percent"+i)) {
			checkMax("skilltrain"+i);
			i++;
		}
		add_skill();
		window.intFocus = false;
	}
}

function statConv(stat) {	//converts stat number into their current value
	switch (stat) {
		case 1: return document.Str.Strength.value*1;
			break;
		case 2: return document.Dex.Dexterity.value*1;
			break;
		case 3: return document.Con.Constitution.value*1;
			break;
		case 4: return document.Spi.Spirit.value*1;
			break;
		case 5: return document.Int.Intelligence.value*1;
	}
}

function skillCountAdj(removed) {	//function adjusts the global variable 'skillcount' to what it should be
	var idArray = new Array("skillid","skillbonus","skillname","skill_percent","skilltrain","skillmin","skill");
	if (removed != window.skillCount) {
		for (i=removed; i<window.skillCount; i++) {
			for (var count=0; count<=idArray.length-1; count++) { //why is there two element declarations? when this checks there is TWO with the same ID (since we've duplicated an element), we change the first
				element = document.getElementById(idArray[count]+(i+1));
				element.id = idArray[count]+i;
				element.name = idArray[count]+i;
			}
		}
	}
	window.skillCount--; //this has to be called even if it doesn't have to adj the order. Put this inside the if statement and it no longer works.
}

if (document.captureEvents && Event.KEYUP) {
	document.captureEvents( Event.KEYUP );
}
document.onkeyup = alertkey;

function alertkey(e) {	//in short, if scroll lock is pressed, note it down in the global variable
	if( !e ) {	//if the browser did not pass the event information to the function, we will have to obtain it from the event register
		if( window.event ) {	//Internet Explorer
			e = window.event;
		} else {	//total failure, we have no way of referencing the event
			return;
		}
	}

	if( typeof( e.keyCode ) == 'number'  ) {	//DOM
		e = e.keyCode;
	} else if( typeof( e.which ) == 'number' ) {	//NS 4 compatible
		e = e.which;
	} else if( typeof( e.charCode ) == 'number'  ) {	//also NS 6+, Mozilla 0.9+
		e = e.charCode;
	} else {	//total failure, we have no way of obtaining the key code
		return;
	}

	if (e == "145") {
		if (window.scrollLock) {
			window.scrollLock = false;
		} else {
			window.scrollLock = true;
		}
	}
}

function focusInc(id) {	//either decrements or increments depending on the status of the scroll-lock key
	var element = document.getElementById(id);
	var inc = 0;
	if (window.lastFocused == id) {
		if (window.scrollMsg) {
			alert("Different ways of adding/subtracting training points: \n\n\t" +
					"Input the amount of trains you wish to commit. \n\t" +
					"Clicking this input will increment the value inside. \n\t" + 
					"Pressing 'Scroll Lock' will cause the value to decrement when clicked.\n\t" + 
					"Clicking only works if the input already has focus. \n\t" +
					"Blank input will default to zero. \n\t" + 
					"'NaN' = Not a Number and means you have tried to be creative with your mathematics.");
			window.scrollMsg = false;
		}
		if (window.scrollLock && element.value != "0" && element.value != "") {
			inc = -1;
		} else if (!window.scrollLock) {
			inc = 1;
		}
		element.value = 1*element.value + inc;
		checkMax(id);
	}
	window.lastFocused = id;
	element.select();
}

function checkMax(id) {	//checks the max amount of trains possible
	var idValue = document.getElementById(id).value*1;
	var powerMax = parseInt(document.getElementById(id.replace("powerrank","powermax")).value);
	var intel = document.Int.Intelligence.value*1;

	if (idValue > parseInt(document.getElementById("remTrains").value)) { //otherwise this flicks trains back and forth which is super annoying.
		document.getElementById(id).value = "";
		add_skill();
	}
	var trains = parseInt(document.getElementById("remTrains").value);

	while (idValue > powerMax || idValue > trains || (id.search("skill") != -1 && idValue > window.skillCap[intel-5])) {
		idValue--;
	}
	if (idValue==window.skillCap[intel-5] && id.search("skill") != -1) {
		document.getElementById(id).className = "skillcap";
		window.capActive = true;
	} else {
		document.getElementById(id).className = "";
		window.capActive = false;
	}
	document.getElementById(id).value = idValue;
	add_skill();
}

function add_skill() {	//massive function that updates and syncronises all the skill and power related information in the variables, as well as the ones in html
	updateSkillsLoc();
	var i;
	if (window.powersLoc.length != 0) {
		for (i=0; i<=window.powersLoc.length-1; i++) { //checks if required powers and skills (for the powers) are still valid, if not remove
			var powerReq1 = window.powersRequiredPower1[parseInt(document.getElementById("powerid"+i).value)];
			var powerReqRank1 = window.powersRequiredPowerRank1[parseInt(document.getElementById("powerid"+i).value)];
			var powerReq2 = window.powersRequiredPower2[parseInt(document.getElementById("powerid"+i).value)];
			var powerReqRank2 = window.powersRequiredPowerRank2[parseInt(document.getElementById("powerid"+i).value)];
			if (arraySearchB(window.powersLoc,powerReq1)) {
				var powerCurReqRank1 = document.getElementById("powerrank"+arraySearchI(window.powersLoc,powerReq1)).value*1 +
					1*document.getElementById("powerbonus"+arraySearchI(window.powersLoc,powerReq1)).value;
				if (powerCurReqRank1 < powerReqRank1) {
					clearPower("powerclear"+i);
				}
			}
			if (arraySearchB(window.powersLoc,powerReq2)) {
				var powerCurReqRank2 = document.getElementById("powerrank"+arraySearchI(window.powersLoc,powerReq2)).value*1 +
					1*document.getElementById("powerbonus"+arraySearchI(window.powersLoc,powerReq2)).value;
				if (powerCurReqRank2 < powerReqRank2) {
					clearPower("powerclear"+i);
				}
			}
			var skillReq1 = window.powersRequiredSkill1[parseInt(document.getElementById("powerid"+i).value)];
			var skillReq2 = window.powersRequiredSkill2[parseInt(document.getElementById("powerid"+i).value)];
			var skillReqRank1 = window.powersRequiredSkillRank1[parseInt(document.getElementById("powerid"+i).value)];
			var skillReqRank2 = window.powersRequiredSkillRank2[parseInt(document.getElementById("powerid"+i).value)];
			if (arraySearchB(window.skillsLoc,skillReq1)) {
				var skillCurReqRank1 = document.getElementById("skill_percent"+arraySearchI(window.skillsLoc,skillReq1));
				if (skillCurReqRank1*1 < skillReqRank1) {
					clearPower("powerclear"+i);
				}
			}
			if (arraySearchB(window.skillsLoc,skillReq2)) {
				var skillCurReqRank2 = document.getElementById("skill_percent"+arraySearchI(window.skillsLoc,skillReq2));
				if (skillCurReqRank2*1 < skillReqRank2) {
					clearPower("powerclear"+i);
				}
			}
		}
	}
	updateSkillsLoc();
	var idName = new Array("skilltrain","skilltrain","skillbonus");
	var train = new Array();
	var trains = new Array();
	var bonus = new Array();
	var skillArray = new Array(train,trains,bonus);
	var baseskill = new Array();
	var points = window.trainingPoints;
	var total = 0;
	var power = 0;
	var rank = new Array();
	var running;
	for (var arrayCount=0; arrayCount<=skillArray.length-1;arrayCount++) { //fills the arrays
		i=0;
		while (document.getElementById(idName[arrayCount]+i)) { //checks if element exists, if it does, loop continues
			skillArray[arrayCount][i] = document.getElementById(idName[arrayCount]+i).value*1;
			i++;
		}
	}

	var intel = document.Int.Intelligence.value*1;
	for (i=0; i<=train.length-1; i++) {
		var statID = arraySearchI(window.skillstatsSkill, document.getElementById("skillname"+i).value);
		var stat1 = statConv(window.skillstatsStat1[statID]);
		var stat2 = stat1;
		if (window.skillstatsStat2[statID] != "") {
			var stat2 = statConv(window.skillstatsStat2[statID]);
		} 
		baseskill[i]=((0.00017*(intel*intel))+(0.1166*intel))+((0.00007*(stat1*stat1))+(0.0777*stat1))/2+((0.00007*(stat2*stat2))+(0.0777*stat2))/2+6.35;
	}

	for (i=0; i<=train.length-1; i++) {
		if (document.getElementById("skillname"+i).value == "Running") {	//damn running fix :(
			running = 2;
		} else {
			running = 1;
		}
		trains[i] = trains[i]*1;
		switch (true) {
			case (train[i]*running <= 10): trains[i] = (bonus[i]*1)+trains[i]*2;
				break;
			case (train[i]*running > 10 && train[i]*running <= 89): trains[i] = (bonus[i]*1)+trains[i]*1+(10/running);
				break;
			case (train[i]*running > 89 && train[i]*running <= 110): trains[i] = (bonus[i]*1)+100/running+((trains[i]-(90/running))/2);
				break;
			case (train[i]*running > 110 && train[i]*running <= 130): trains[i] = (bonus[i]*1)+110/running+((trains[i]-(110/running))/3);
				break;
			case (train[i]*running > 130 && train[i] <= 150): trains[i] = (bonus[i]*1)+116.6/running+((trains[i]-(130/running))/4);
		}
	}
	
	i=0;
	while (document.getElementById("skill_percent"+i)) {
		if (document.getElementById("skillname"+i).value == "Running") {	//damn running fix :(
			running = 2;
		} else {
			running = 1;
		}
		document.getElementById("skill_percent"+i).value = Math.round(trains[i]+baseskill[i])*running;
		i++;
	}
	i=0;
	
	while (document.getElementById("powerrank"+i)) {
		rank[i]=document.getElementById("powerrank"+i).value*1;
		i++;
	}

	for (i=0;i<=rank.length-1;i++) {
		power = power+rank[i];;
	}
	
	for (i=0;i<=train.length-1;i++) {
		total=total+train[i];
	}
	document.training.point.value = points-total-power;
	
	for (i=0; i<=window.possibleSkills.length-1; i++) {	//this adds new skills as they become available when requirements are met
		for (var count=0; count<=window.skillCount; count++) { //removes skills when requirements are no longer met
			//if (document.getElementById("skillmin"+count).value != "" && document.getElementById("skillmin"+count).value != "0") {
				var key = parseInt(document.getElementById("skillid"+count).value*1);
				for (var x=0; x<=window.skillCount; x++) {
					if ((document.getElementById("skillname"+x).value == window.skillsRequiredSkill[key]) &&
						(parseInt(document.getElementById("skill_percent"+x).value) < (1*window.skillsRequiredRank[key]))) {
						window.activeSkills.splice(arraySearchI(window.activeSkills,key),1);
						document.getElementById("skill"+count).parentNode.removeChild(document.getElementById("skill"+count));
						skillCountAdj(count);
						updateSkillsLoc();
					}
				}
			//}
		}
		var key = window.possibleSkills[i];
		if (!arraySearchB(window.activeSkills,key)) { //add new skills when requirements are met
			var count = 0;
			while (document.getElementById("skillname"+count)) {
				if ((window.skillsRequiredSkill[key] == document.getElementById("skillname"+count).value) && 
					(parseInt(document.getElementById("skill_percent"+count).value*1) >= window.skillsRequiredRank[key])) {
					window.activeSkills.push(window.possibleSkills[i]);
					processSkill(window.skillsSkill[key],window.skillsLevel[key],key);
					document.getElementById("skillmin"+window.skillCount).value = window.skillsRequiredRank[key];
					add_skill();
				}
				count++;
			}
		}
	}
	
	if (window.selectedPower != null) {
		powerOptionSelect(window.selectedPower);
	} else //if (window.selectedPower == null) {
		{ powerSelectInit();
	}
}

function RemoveRune() {	//is the function that phisically removes the rune from the select box
    var x=document.getElementById("appliedrunes");
    x.remove(x.selectedIndex);
}

function remove_rune() {	//undoes all the changes made by the selected rune that is being removed
	var rune=document.runes.appliedrunes.value;
	var key = arraySearchI(window.traitKey,rune);	//this is the 'key' or location in the trait arrays of our rune.
	var race = parseInt(document.drop_list.race.value);
	var baseClass = parseInt(document.drop_list.subclass.value);
	var profession = parseInt(document.drop_list.profession.value);
	var count;
	RemoveRune();
	disableRadio(false,rune);

	if (arraySearchB(window.traitKey,rune)) {
		window.traitActive.splice(arraySearchI(traitActive,key),1);
		document.getElementById("statPoints").value = parseInt(document.getElementById("statPoints").value)+window.traitCost[key]; //add the cost back to pending stat points
		for (var i=0; i<=window.traitEffectArray.length-1; i++) {
			var effectName = window.traitEffectNameArray[i][key]+"";
			var effectValue = window.traitEffectArray[i][key]+"";
			if (effectValue.search("~") != -1) {
				var tempNum = parseInt(effectValue.substr(0,effectValue.search("~")));
				var min = document.getElementById("min"+effectName);
				var max = document.getElementById("max"+effectName);
				var cur = document.getElementById("cur"+effectName);
				min.value = parseInt(min.value)-tempNum;
				cur.value = parseInt(cur.value)-tempNum;
				max.value = parseInt(max.value)-parseInt(effectValue.substr(effectValue.search("~")+1));
			} else if (effectName != "") {
				var runeName = window.traitName[(arraySearchI(window.traitKey,rune))]; alert
				window.activeSkills.splice(arraySearchI(window.skillsFor,runeName),1);
				if (window.skillCount > 0) {
					for (count=1; count<=window.skillCount; count++) {
						if (window.skillsFor[parseInt(document.getElementById("skillid"+count).value)] == runeName) {
							document.getElementById("skill"+count).parentNode.removeChild(document.getElementById("skill"+count));
							skillCountAdj(count);
						}
					}
				}
				skillNum = arraySearchI(window.skillsLoc,effectName);
				if (skillNum == 0) {
					document.getElementById("skillname0").value = "";
					document.getElementById("skill_percent0").value = "0";
					document.getElementById("skilltrain0").value = "";
					document.getElementById("skillbonus0").value = "";
					document.getElementById("skillid0").value = "";
				}
				add_skill();
			}
		}
		var statArray = new Array();
		var tempValue;

		for (count=window.minArrayId.length-1; count>0; count--) { //removing the item from the minarrays I THINK I HAVE IT - WEEEEEEEEEEEE!!!
			if (minArrayId[count].search(rune) != -1) {
				statArray.push(minArrayId[count].substr(rune.length));
				minArrayId.splice(count,1);
				minArrayValue.splice(count,1);
			}
		}
		if (statArray.length != 0) {
			for (var aryCount in statArray) {
				tempValue = 0;
				for (count in window.minArrayId) {
					if (minArrayId[count].search(statArray[aryCount]) != -1 && minArrayValue[count] > tempValue) {
						tempValue = minArrayValue[count];
					}
				}
				if (tempValue != 0) {
					document.getElementById("min"+statArray[aryCount]).value = tempValue;	//assign the new min
				}
			}
		}
	} else if (arraySearchB(window.disciplinesKey,rune)) {
		key = arraySearchI(window.disciplinesKey,rune);
		window.activeDiscs.splice(arraySearchI(window.activeDiscs,rune),1);
		if (window.disciplinesName[key] == "Valkyr") {	//For Valkyr since it's the only disc that adjusts stats
			document.getElementById("curIntelligence").value = parseInt(document.getElementById("curIntelligence").value)+5;
			document.getElementById("minIntelligence").value = document.getElementById("curIntelligence").value;
			document.getElementById("maxStrength").value = parseInt(document.getElementById("maxStrength").value)-25;
		}
		for (var count=0; count<=window.skillsLoc.length-1; count++) {
			var remSkill = true;
			for (var i=0; i<=window.skillsFor.length-1; i++) {
				if (window.skillsLoc[count] == window.skillsSkill[i] && window.skillsFor[i] == window.disciplinesName[key]) {
					for (var x=0;x<=window.skillsFor.length-1; x++) {
						if (window.skillsLoc[count] == window.skillsSkill[x] && (window.skillsFor[x] == window.raceNames[race-1] || window.skillsFor[x] == window.classNames[baseClass] 
							|| window.skillsFor[x] == window.professionID[profession])) {
							remSkill = false;
						}
					}
				}
			}
			for (var i=0; i<=window.skillsFor.length-1; i++) {
				if (window.skillsLoc[count] == window.skillsSkill[i] && window.skillsFor[i] == window.disciplinesName[key]) {
					if (remSkill) {
						window.activeSkills.splice(arraySearchI(window.skillsFor,rune),1);
						if (count > 0) {
							document.getElementById("skill"+count).parentNode.removeChild(document.getElementById("skill"+count));
							skillCountAdj(count);
						} else {
							document.getElementById("skillname0").value = "";
							document.getElementById("skill_percent0").value = "0";
							document.getElementById("skilltrain0").value = "";
							document.getElementById("skillbonus0").value = "0";
							document.getElementById("skillid0").value = "";
						}
					} else {
						document.getElementById("skillbonus"+count).value = (document.getElementById("skillbonus"+count).value*1)-skillsLevel[i];
					}
					add_skill();
				}
			}
		}
		if (window.activeDiscs.length == 3) {	//if it equals three than that means that they are all disabled, so we need to reset them.
			discReset();
		}
		discCheck();
	} else if (window[rune.substr(0,rune.length-1).toLowerCase()] != -1) {
		var remaining = document.getElementById("statPoints");
		var runeType = parseInt(rune.charAt(rune.length-1))-1;
		rune = rune.substr(0,rune.length-1);
		var runeNum = arraySearchI(window.attributes,rune);
		var realMax = window.raceArrays[parseInt(document.drop_list.race.value)-1][runeNum+5];// + window.classArray[parseInt(document.drop_list.subclass.value)][runeNum]; //returns the default max of the build w/o
		var realMin = (window.raceArrays[parseInt(document.drop_list.race.value)-1][runeNum]-5) + window.classArray[parseInt(document.drop_list.subclass.value)][runeNum];
		for (var i=0; i<=window.traitActive.length-1; i++) {	//adds the trait effects to the selected stat
			for (var count=0; count<=window.traitEffectArray.length-1; count++) {
				effectName = window.traitEffectNameArray[count][window.traitActive[i]];
				effectValue = window.traitEffectArray[count][window.traitActive[i]];
				if (effectName == rune && effectValue.search("~") != -1) {
					realMax += parseInt(effectValue.substr(effectValue.search("~")+1));
					realMin += parseInt(effectValue.substr(effectValue.search("~")+1));
				}
			}
		}
		var cost = new Array(3,4,5,8,9,11,12,15);
		var min = document.getElementById("min"+rune);
		var max = document.getElementById("max"+rune);
		var cur = document.getElementById("cur"+rune);
		max.value = realMax;	//parseInt(max.value)-((window[rune.toLowerCase()]+1)*5); //work out how to apply realMax
		min.value = realMin;
		if (runeType == 7) {	//of the gods bonus adjust
			var bonus = 1;
		} else {
			var bonus = 0;
		}
		remaining.value = (parseInt(remaining.value) + cost[runeType] + ((parseInt(cur.value)-(runeType+2))-parseInt(max.value)))-bonus;
		cur.value = max.value;
		window[rune.toLowerCase()] = -1;
	}
	updateSkillsLoc();
}

function xstooltip_findPosX(obj) {
	var curLeft = 0;
	if (obj.offsetParent) {
		while (obj.offsetParent) {
			curLeft += obj.offsetLeft;
			obj = obj.offsetParent;
		}
	} else if (obj.x) {
		curLeft += obj.x;
	}
	return curLeft;
}

function xstooltip_findPosY(obj) {
    var curTop = 0;
    if (obj.offsetParent) {
		while (obj.offsetParent) {
			curTop += obj.offsetTop
			obj = obj.offsetParent;
		}
    } else if (obj.y) {
		curTop += obj.y;
	}
    return curTop;
}

function xstooltip_show(tooltipId, parentId, posX, posY) {
	it = document.getElementById(tooltipId);

	if ((it.style.top == '' || it.style.top == 0) 
		&& (it.style.right == '' || it.style.right == 0)) {
		// need to fixate default size (MSIE problem)
		it.style.width = it.offsetWidth + 'px';
		it.style.height = it.offsetHeight + 'px';
		
		img = document.getElementById(parentId); 

		// if tooltip is too wide, shift left to be within parent 
		if (posX + img.offsetWidth > it.offsetWidth) {
			posX = it.offsetWidth - img.offsetWidth;
		}
		if (posX < 0 ) {
			posX = 0;
		}
		
		x = xstooltip_findPosX(img) + posX;
		y = xstooltip_findPosY(img) + posY;

		it.style.top = y - 30 + 'px';
		it.style.left = x - it.offsetWidth - 40 + 'px';
	}
	it.style.visibility = 'visible'; 
}

function xstooltip_hide(id) {
	it = document.getElementById(id); 
	it.style.visibility = 'hidden'; 
}

function hide_div(){	//hides all of the divs when called on
    var traitNames=new Array("agile_div","ambidexterity_div","blacksmithsapprentice_div","blessing_div","bloodofthedesert_div","bloodofthedragon_div","bloodofthenorth_div","borninthecountry_div",
		"bornoftheethyri_div","bornofthegwendannen_div","bornoftheinvorri_div","bornoftheirydnu_div","bornofthetaripontor_div","bowyerborn_div","brawler_div","brilliantmind_div","bruiser_div",
		"changeling_div","clever_div","darkwhispers_div","divinetouch_div","eyesoftheeagle_div","faithoftheages_div","fleetoffoot_div","giantsblood_div","healthyasanox_div","hearty_div","herosstrength_div",
		"hunter_div","increasedconstitution_div","increaseddexterity_div","increasedintelligence_div","increasedspirit_div","increasedstrength_div","ironwill_div","juggernaut_div",
		"knifefighter_div","knightssquire_div","lightningreflexes_div","lucky_div","mercenary_div","mighty_div","militarytraining_div","precise_div","priestsacolyte_div","proficientwithaxes_div",
		"proficientwithbows_div","proficientwithcrossbows_div","proficientwithdaggers_div","proficientwithhammers_div","proficientwithpolearms_div","proficientwithspears_div",
		"proficientwithstaves_div","proficientwithswords_div","raisedbybarbarians_div","raisedbycentaurs_div","raisedbydwarves_div","raisedbyelves_div","raisedbythievesguild_div",
		"raisedinthewoods_div","scionofdarkhelegeur_div","scionofgwaridorn_div","scionoftwathedilion_div","sellsword_div","sharpshooter_div","shopkeepersapprentice_div","snakehandler_div",
		"soldtothepits_div","soldierborn_div","stormborn_div","taintofchaos_div","taintofmadness_div","taughtbyblademaster_div","taughtbymasterthief_div","tireless_div","toughasnails_div",
		"toughhide_div","trainedbymasterofarms_div","travellingperformer_div","truefaith_div","wanderer_div","warlordspage_div","witchsight_div","wizardsapprentice_div","woodsman_div",
		"ofthegods_div","enhanced_div","exceptional_div","amazing_div","incredible_div","great_div","heroic_div","legendary_div"/*,"template_div"*/);
	
	for (var i in traitNames) {
		document.getElementById(traitNames[i]).style.visibility = 'hidden';
	}
}

function submit() {	//creates the formatted output of the template
	var proceed = true;
	if (document.getElementById("remTrains").value != "0") {
		if (!(confirm("You still have training points outstanding, are you sure you want to continue?"))) {
			proceed = false;
		}
	} else if (document.getElementById("statPoints").value != "0") {	//put this as else if because the public don't want to say no they do not want to continue more than once.
		if (!(confirm("You still have stat points outstanding, are you sure you want to continue?"))) {
			proceed = false;
		}
	}
	if (proceed) {
		var newWindow;
		var br = "<br/>";
		var max;
		var cur;
		var buffer = "                                           ";
		var trains;
		var percent;
		var name;
		var rank;
		var i;
		
		newWindow = window.open("","","status,height=700,width=800");
		newWindow.focus();
		var newContent = "<HTML><HEAD><TITLE>Template</TITLE></HEAD><body><pre>-------The Basics---------" + br + br;
		newContent += " Race:  " + buffer.substr(0,window.curProfession.length+6-window.curRace.length) + window.curRace + br + 
			" Class:  " + buffer.substr(0,window.curProfession.length+5-window.curClass.length) + window.curClass + br +
			" Profession:  " + window.curProfession + br +
			 br +
			"------Applied Runes-------" + br + br;
		for (i=0; i<=document.getElementById('appliedrunes').options.length-1; i++) {
			newContent += " " + document.getElementById('appliedrunes').options[i].text + br;
		}

		newContent += br + "----------Stats-----------" + br + br;
		for (i=0; i<=window.attributes.length-1; i++) {
			max = document.getElementById("max"+window.attributes[i]).value;
			cur = document.getElementById("cur"+window.attributes[i]).value;
			newContent += " " + window.attributes[i] + ":" + buffer.substr(0,(14-window.attributes[i].length)+(3-(cur.length))) + cur + "/" + max + br;
		}

		newContent += br + "----------Skills----------" + br + br;
		for (i=0; i<=window.skillCount; i++) {
			trains = document.getElementById("skilltrain"+i).value;
			if (trains != "" && trains != 0) {
				percent = document.getElementById("skill_percent"+i).value;
				name = document.getElementById("skillname"+i).value;
				newContent += " " + name + buffer.substr(0,(24-name.length)+(3-percent.length)) + percent + "%" + buffer.substr(0,4-trains.length) + "(" + trains + " trains)" + br;
			}
		}
		
		newContent += br + "----------Powers----------" + br + br;
		for (i=0; i<=window.powerCount; i++) {
			trains = 1*document.getElementById("powerrank"+i).value + 1*document.getElementById("powerbonus"+i).value;
			if (trains != 0) {
				rank = trainConvert(trains);
				name = document.getElementById("powername"+i).value;
				trains = trains+"";
				newContent += " " + name + buffer.substr(0, 33-name.length+(2-trains.length)) + trains + buffer.substr(0,13-rank.length) + "(" + rank + ")" + br;
			}
		}/*
		if (confirm("Would you like to include powers that cannot be trained?")) {
			var allDiscs = window.activeDiscs.join();
			for (i=0; i<=window.powersFor.length-1; i++) {
				if (window.powersRankMax[i] == "") {
					rank = trainConvert(window.powersRankMin[i]);
					name = window.powersName[i];
					if (allDiscs.search(window.powersFor[i].toLowerCase().replace(" ", "")) != -1) {
						cur = window.powersFor[i];
					} else {
						cur = "";
					}
					switch (window.powersFor[i]) {
						case (window.curRace): case (window.curClass): case (window.curProfession): case (cur):
							newContent += " " + name + buffer.substr(0,33-name.length+1) + "-" + buffer.substr(0,13-rank.length) + "(" + rank + ")" + br;
					}
				}
			}
		}*/
		newContent += "</pre></BODY></HTML>";
		newWindow.document.write(newContent);
		newWindow.document.close(); // close layout stream
	}
}

function submitTemplate() {
	if (document.getElementById('remTrains').value == "0" || document.getElementById("statPoints").value == "0") {
		alert("We only store completed template in the databse, please complete your template and then try again");
	} else if (!confirm("Once submitted, templates can only be delete and NOT edited. Are you sure that you are done?")) {
		return;
	}
	prompt("Enter name of your toon.","");
	prompt("Enter YOUR name or alias (this will be displayed publically as the 'author').","");
	prompt("Enter password so you can delete this template if you so choose to.","");
	prompt("Enter the Captcha Image","");
	prompt("","");
}

function trainConvert(trains) {	//converts the training points in a power to its appropriate rank
	switch (true) {
		case (trains == 40): return "Grand Master";
		case (trains >= 36): return "Master";
		case (trains >= 33): return "Expert";
		case (trains >= 30): return "Proficient";
		case (trains >= 26): return "Competent";
		case (trains >= 22): return "Skilled";
		case (trains >= 18): return "Journeyman";
		case (trains >= 15): return "Adept";
		case (trains >= 11): return "Neophyte";
		case (trains >= 8): return "Apprentice";
		case (trains >= 4): return "Beginner";
		case (trains >= 2): return "Novice";
		case (trains >= 0): return "Untrained";
	}
}

function resetSkills() {	//resets the trains in all the skills
	var count = 0;
	while (document.getElementById("skillname"+count)){
		document.getElementById("skilltrain"+count).value = "";
		count++;
	}
	add_skill();
}

function resetPowers() {	//resets all of the powers to their starting arrangement
	while (window.powerCount != 0) {
		document.getElementById("power"+window.powerCount).parentNode.removeChild(document.getElementById("power"+window.powerCount));
		window.powerCount -= 2;
	}
	clearPower("powerclear1");
	clearPower("powerclear0");
}

var tabLinks = new Array();
var contentDivs = new Array();

function init() {

  // Grab the tab links and content divs from the page
  var tabListItems = document.getElementById('traitButtons').childNodes;
  for ( var i = 0; i < tabListItems.length; i++ ) {
	if ( tabListItems[i].nodeName == "LI" ) {
	  var tabLink = getFirstChildWithTagName( tabListItems[i], 'A' );
	  var id = getHash( tabLink.getAttribute('href') );
	  tabLinks[id] = tabLink;
	  contentDivs[id] = document.getElementById( id );
	}
  }
  tabListItems = document.getElementById('level75Buttons').childNodes;
  for ( var i = 0; i < tabListItems.length; i++ ) {
	if ( tabListItems[i].nodeName == "LI" ) {
	  var tabLink = getFirstChildWithTagName( tabListItems[i], 'A' );
	  var id = getHash( tabLink.getAttribute('href') );
	  tabLinks[id] = tabLink;
	  contentDivs[id] = document.getElementById( id );
	}
  }

  // Assign onclick events to the tab links, and
  // highlight the first tab
  var i = 0;

  for ( var id in tabLinks ) {
	tabLinks[id].onclick = showTab;
	tabLinks[id].onfocus = function() { this.blur() };
	if ( i == 0 ) tabLinks[id].className = 'selected';
	i++;
  }

  // Hide all content divs except the first
  var i = 0;

  for ( var id in contentDivs ) {
	if ( i != 0 ) contentDivs[id].className = 'tabContent hide';
	i++;
  }
}

function showTab() {
  var selectedId = getHash( this.getAttribute('href') );
  // Highlight the selected tab, and dim all others.
  // Also show the selected content div, and hide all others.
  for ( var id in contentDivs ) {
	if ( id == selectedId ) {
	  tabLinks[id].className = 'selected';
	  contentDivs[id].className = 'tabContent';
	} else {
	  tabLinks[id].className = '';
	  contentDivs[id].className = 'tabContent hide';
	}
  }

  // Stop the browser following the link
  return false;
}

function getFirstChildWithTagName( element, tagName ) {
  for ( var i = 0; i < element.childNodes.length; i++ ) {
	if ( element.childNodes[i].nodeName == tagName ) return element.childNodes[i];
  }
}

function getHash( url ) {
  var hashPos = url.lastIndexOf ( '#' );
  return url.substring( hashPos + 1 );
}