
1. @depends testEmpty   改测试方法依赖testEmpty方法的返回值,且该返回值作为该方法的一个参数传递

2. @depends testProducerFirst
   @depends testProducerSecond  其第一个参数是第一个生产者提供的基境，第二个参数是第二个生产者提供的基境

3. @dataProvider additionProvider   additionProvider方法为数据供给器,该方法必须返回一个数组,且每一项都是数组;或者是一个实现Iterator接口的对象,在对它进行迭代的每一步产生一个数组


4.@expectedException
  @expectedExceptionMessage
  @expectedExceptionMessageRegExp
  @expectedExceptionCode

5. $this->setExpectedException($exceptionName, $exceptionMessage, $exceptionCode);
   $this->setExpectedExceptionRegExp($exceptionName, $exceptionMessage, $exceptionCode);