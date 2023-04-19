# Readme of Toy Framework
- Author: Hwi Jun KIM (@pcaffeine)
- Address: euler.bonjour@gmail.com / https://github.com/khj1977/
- Japanese version of readme: https://github.com/khj1977/toy_framework/blob/master/README_JP.md
- Code: https://github.com/khj1977/toy_framework/

# Preliminary
- Aim: To make better working envinronment both for members and top execs especially for Japan;
- Objective: To make business application framework for operation;
- Methodology: 1. Analysis of business and 2. design, implementation and investigation of design pattern.

# Introduction
Less working time. Small size of team of operation. Better sales profit. These seem conflicted. How is it archived parallely? This framework is an answer.

If you talk about department or division of your company, which division do you come up? Marketing? Product Planning? System? Accounting? Human Resource? Author supposes that these divisions could be known even one is university or high school student.

Marketing? You may use Excel, BI, Power Point and much more. It seems gorgeous from ordinary person. However, there is not gorgeous, but importatnt job. That is operation. Actually, without markteting and strategy, company loose where they want to go. Without Product Planning, no one can make their product to sell. Without System, it is not possible to run company since there are many IT in a company. Hey, in that time, System makes what? EC? That is fine. It is about web. DX? What is it? It is business application. Operation has much tight connection with system.

In this repositotry framework for operation named ToyFramework is introduced. You can check every source code, comment and log since they all are writen by English. There is only 1 Japanese document which is README.md. Why Japanese? Because this framework is primary, for Japanese working evironment. But it could be used for US, UK, France and other countries.

Here is author's brief introduction of this framework.

# Business, working environment and Japan
Oh, it is 7 o'clock. I have to wake up. There is business! Every person gets up early time and go to office. Although after COVID, remote work gets ordinary thing, office work is still required.

Too packed. Too touched. Tired. That is a word of train at Japan or Tokyo. Once we got into office, there is many time to work. "Zangyo" in Japanese which is overtime work. In a company author joined, there is one member who works until 23 o'clock every day. Moreover, it would impossible to work with a job if topline gets higher. Author was in Systems department. After small sensibity analysis of PL and some small thought of operation, author talked with general manager (GM) of system and executive officer. Hey, we stop system development with marketing. But we use much time for optimization of operation for our employee and business. We are venture!

Impact to topline, operation profit, better cash flow and work life balance of member. That is our purpose.

Less but enough number of member. Easy to take paid vacation. That could be realized by better operation and system.

Paid vacation? In Japan, generally speaking, in ordinary company, it is difficult to take paid vacation. Why? That is because of design of their business or operation. That is a problem especially for working women. Because of a child, one need paid vacation. It could be said child gets easy to cold. Then, one should take paid vacation and take care of their child. Go to travel with paid vacation? That's fine. Member gets refreshed, and it would be good for their performance to work. But it could not be. If operation is designed appropriately, paid vacation could be taken. 

One thing which should be memtion is if working time gets lesser, one go to shopping or easting something to outside after their work. It would be good effect to GDP of a country. Working time is matter for a member but also for top exec and it is for a country or government as well.

We suposed that by optimizing business process, it would be possible to reduce load or time to work who are in operations department. Also, it would be possible to work with high topline with few number of person in operations division. It results high operation profit. Actually, we did it. In that time, no system but Excel prototyping which express and emulate primitive system or business had been used.

There is always business process behind real business and system for them. That is a start point of this framwork.

# What is this framework?
MVC? MVVM? Play? Rails? They are all about view. Little logic but not backend. Actually, in this framework, there are codes for view which deploys composite view pattern. But that is for reducing load to make view and concentrate to development of business process.

Business process express actual procedure of business. It is close to Model of ordinary MVC application. But different idea. Actually, there are 3 or 5 pages as A4 document with block diagram in a company which express business of their department. Each block express process and each process related to each other. Connect, if-then-else block and much more. Before to implement their system application, it is required to optimize their business.

In real business situation, business process is changed dynamically. So a developer required to make system fastly and by agile. Thus, low load to make view is required. Also, there are code to make view automatically with scaffold and OR/Mapper. The important thing of this scaffold is there is no template or skelton code but everything is done dynamically with meta data.

Since every code or classes are made pluggable, a developmer may get high productivity onece one got familar with this framework.

# Restful Objects

Micro service. That is trend word in recent years in IT industry. Actually, in this framework, system is assumed to be connected with REST. API? That is fine. But more important thing is, it is possible to transfer method call of a class to another machine. It is magic of meta programming. You can check my framework for this magic. Actually, implementation of this code is not difficult. But as I know, most person seems not to deploy that idea.

If you want to connect code by this framework with your system which made by Scala, Java or C#, you can do that easily. It is dangerous to replace whole system at once. You can replace your old system by agile way.

# Abstract class library for business modelling

There are much more interesting class libray for this framework to make productivity of developer or business analyst higher. Author does not write document but since source is opened, you can check that by youself.

# How to run?
Set environment variable for shell as follows:
- export K_STAGE=Dev
The above is sample for bash. Note that if it were apache, let use appropriate setting directive. Then, DevConfigImpl.php is used under lib dir. And set content of that file appropriately.

Write down setttings to the following config file and copy to config dir.
- lib/config/impl/DevConfigImpl.php
- config/DevConfigImpl.php
- config/StagingConfigImpl.php
- config/ProductionConfigImpl.php

## Comment for how to run
In BaseConfig.php, there are part to determine config file name. See the following:
- $configFileName = sprintf("%sConfigImpl.php", $this->stage);

The following code determine dir of config file.
- protected function getConfigDirPath() {
-     // return "lib/config/impl/";
-     return "config/";
- }

In TheWorld.php, there are the following codes to determine stage of the running process.
- $this->serverEnv = new ServerEnv();
- $this->stage = $this->serverEnv->get("K_STAGE");

Thus, K_Stage would be Dev, Staging or Production. According to that, file name of config will be determined. Note that $stage could be arbitrary words but the previous three strings would be appropriate. Note the above two $this->stage are used in the different context.

## How to run unit test?

In this framework, there is unit test framework. Yes, actually, it is original framework and you do not need to install PHPUnit. The following is the how to run unit test:

- php bin/UnitTestBatch.php Sequential

There is no file named unit_test/Sequential but there is unit_test/TestSequential.php. Other elements of strings are automatically determined. See test code how to define each unit tests. There is ConC naming rule of methods for unit test.

# Why PHP?

If it were biz framework, why not Java, Scala or C#? If it were LL, why not Ruby? That is because of the fact that PHP is well balanced langage and there are many supporting tool to develop for production use. For instance,

- Meta-programming can be done with flexible LL langage.
- Type hint could be applied as well as dynamic typing of LL.
- I have to admit Ruby is good language. But not-well designed Ruby code is hard to maintain. However, well-designed PHP code is easy to maintain. Server side biz code is used for long term, maintenance of code is important.
- Since a power of meta-programming used, even C# is used, there would be dynamic type, then, it would be close to a code of PHP version.
- OO is based on Java and enough.
- JIT exists and it would be fast (no performance test by myself yet)
- fast-cgi or cache may be used, and since it is pre-compiled, it would be fast enough even it were LL.
- phar is exist and it is easy to deploy and manage.
- build tool? Although it is NOT PHP native, rake or gradle may be candidate of build tool
- Self maintenance or customize by a company which utilize this framework may be easy to be done. Since PHP itself is easy to understand some simple customize or maintenance by a user company could be done without SIer which makes application based on this framework. I think this is a win-win relation to me, a SIer and a user company.

Enjoy with this framework!