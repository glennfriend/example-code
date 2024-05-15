<?php


class UserDataApiRequestTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->request = new ______ApiRequest();
    }

    /**
     * @test
     */
    public function rules_should_work()
    {
        $validator = Validator::make([
            'userId' => '333-333-4444',
            'users'  => [
                [
                    "userId" => 1111,
                    "email"  => "test@example.com",
                ],
            ],
        ], $this->request->rules());

        $this->assertEmpty($validator->errors()->keys());
    }

    /**
     * @test
     */
    public function rules_should_not_work()
    {
        $validator = Validator::make([], $this->request->rules());

        $this->assertSame([
            'userId',
            'users',
        ], $validator->errors()->keys());
    }
}
